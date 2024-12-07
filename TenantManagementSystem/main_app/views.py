from django.shortcuts import render, get_object_or_404
from django.contrib import messages

# Create your views here.
def home(request):
    return render(request,'home.html')


def about(request):
    return render(request,'about.html')


from django.shortcuts import render, redirect
from django.core.mail import send_mail
from django.conf import settings
from django.contrib import messages



# View for the Contact Us page
def contact(request):
    return render(request, 'contact.html')


# View for handling the contact form submission
def contact_form(request):
    if request.method == 'POST':
        name = request.POST.get('name')
        email = request.POST.get('email')
        message = request.POST.get('message')

        # Send email (You can customize this further)
        send_mail(
            f'Contact Us Message from {name}',
            message,
            email,
            [settings.CONTACT_EMAIL],  # Set this in settings.py
            fail_silently=False,
        )

        # Optionally, you can store the message in the database or log it

        # Show success message
        messages.success(request, 'Thank you for reaching out! We will get back to you soon.')
        return redirect('contact')  # Redirect to the contact page after submission

    return redirect('contact')  # If method isn't POST, redirect to contact page

from django.shortcuts import render, redirect
from django.contrib import messages
from django.contrib.auth.hashers import check_password
from django.contrib.auth.decorators import login_required
from .forms import LoginForm, RegisterForm
from .models import Tenants


def login_register(request):
    login_form = LoginForm()
    register_form = RegisterForm()

    if request.method == 'POST':
        form_type = request.POST.get('form_type')

        if form_type == 'login':
            login_form = LoginForm(request.POST)
            if login_form.is_valid():
                identifier = login_form.cleaned_data['identifier']
                password = login_form.cleaned_data['password']

                # Try to find user by first name, last name, or contacts
                try:
                    user = Tenants.objects.filter(
                        first_name=identifier
                    ).first() or Tenants.objects.filter(
                        last_name=identifier
                    ).first() or Tenants.objects.filter(
                        contacts=identifier
                    ).first()

                    if user and check_password(password, user.password):
                        # Store user id in session
                        request.session['tenant_id'] = user.id
                        messages.success(request, 'Login successful!')

                        # Successful login
                        next_url = request.GET.get('next')
                        if next_url:
                            return redirect(next_url)
                        else:
                            return redirect('tenant_details')
                    else:
                        messages.error(request, 'Invalid login credentials')
                except Tenants.DoesNotExist:
                    messages.error(request, 'User not found')

        elif form_type == 'register':
            register_form = RegisterForm(request.POST)

            if register_form.is_valid():
                try:
                    # Check if a user with the same contacts already exists
                    if Tenants.objects.filter(contacts=register_form.cleaned_data['contacts']).exists():
                        messages.error(request, 'A user with this contact number already exists')
                    else:
                        # Explicitly set total_rent, paid, and deficit
                        tenant = register_form.save(commit=False)
                        tenant.total_rent = '22000'  # Default value
                        tenant.paid = '0'  # Default value
                        tenant.deficit = '0'  # Default value
                        tenant.save()

                        messages.success(request, 'Registration successful! You can now log in.')
                        return redirect('login_register')

                except Exception as e:
                    print(f"Exception during registration: {e}")
                    messages.error(request, f'Registration failed: {e}')

    return render(request, 'login_register.html', {
        'login_form': login_form,
        'register_form': register_form
    })


@login_required(login_url='login_register')
def tenant_details(request):
    # Retrieve tenant ID from session
    tenant_id = request.session.get('tenant_id')

    if not tenant_id:
        messages.error(request, 'Please log in to access your details')
        return redirect('login_register')

    try:
        # Fetch tenant details from the database
        tenant = Tenants.objects.get(id=tenant_id)

        # Pass tenant details to the template
        return render(request, 'tenant_details.html', {
            'tenant': tenant
        })

    except Tenants.DoesNotExist:
        messages.error(request, 'Tenant not found')
        return redirect('login_register')


def logout(request):
    # Clear the session
    request.session.flush()
    messages.success(request, 'You have been logged out successfully')
    return redirect('login_register')
