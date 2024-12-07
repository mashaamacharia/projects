# from django import forms
# from .models import Tenants
#
#
# class LoginForm(forms.Form):
#     identifier = forms.CharField(
#         max_length=100,
#         required=True,
#         label="Identifier",
#         widget=forms.TextInput(attrs={
#             'class': 'form-control',
#             'placeholder': 'Enter first name, last name, or contact'
#         })
#     )
#     password = forms.CharField(
#         required=True,
#         label="Password",
#         widget=forms.PasswordInput(attrs={
#             'class': 'form-control',
#             'placeholder': 'Enter your password'
#         })
#     )
#
#
# class RegisterForm(forms.ModelForm):
#     password1 = forms.CharField(
#         required=True,
#         label="Password",
#         widget=forms.PasswordInput(attrs={
#             'class': 'form-control',
#             'placeholder': 'Enter your password'
#         })
#     )
#     password2 = forms.CharField(
#         required=True,
#         label="Confirm Password",
#         widget=forms.PasswordInput(attrs={
#             'class': 'form-control',
#             'placeholder': 'Re-enter your password'
#         })
#     )
#
#     class Meta:
#         model = Tenants
#         fields = ['first_name', 'last_name', 'contacts', 'house_No']
#         widgets = {
#             'first_name': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Enter first name'}),
#             'last_name': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Enter last name'}),
#             'contacts': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Enter contact'}),
#             'house_No': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Enter house number'}),
#         }
#
#     def clean(self):
#         cleaned_data = super().clean()
#         password1 = cleaned_data.get('password1')
#         password2 = cleaned_data.get('password2')
#
#         if password1 and password2 and password1 != password2:
#             raise forms.ValidationError("Passwords do not match.")
#         return cleaned_data

# from django import forms
# from django.contrib.auth.hashers import check_password, make_password
# from .models import Tenants
#
# class LoginForm(forms.Form):
#     identifier = forms.CharField(
#         max_length=30,
#         widget=forms.TextInput(attrs={'placeholder': 'First Name, Last Name, or Contact'})
#     )
#     password = forms.CharField(
#         max_length=128,
#         widget=forms.PasswordInput(attrs={'placeholder': 'Password'})
#     )
#
# class RegisterForm(forms.ModelForm):
#     password1 = forms.CharField(
#         max_length=128,
#         widget=forms.PasswordInput(attrs={'placeholder': 'Password'})
#     )
#     password2 = forms.CharField(
#         max_length=128,
#         widget=forms.PasswordInput(attrs={'placeholder': 'Confirm Password'})
#     )
#
#     class Meta:
#         model = Tenants
#         fields = ['first_name', 'last_name', 'contacts', 'house_No']
#
#     def clean(self):
#         cleaned_data = super().clean()
#         password1 = cleaned_data.get('password1')
#         password2 = cleaned_data.get('password2')
#
#         if password1 and password2 and password1 != password2:
#             self.add_error('password2', "Passwords do not match.")
#
#         return cleaned_data
#
#     def save(self, commit=True):
#         instance = super().save(commit=False)
#         instance.password = make_password(self.cleaned_data['password1'])
#         if commit:
#             instance.save()
#         return instance


from django import forms
from django.contrib.auth.password_validation import validate_password
from django.core.exceptions import ValidationError
from .models import Tenants

class LoginForm(forms.Form):
    identifier = forms.CharField(
        max_length=50,
        label='Username or Contact',
        widget=forms.TextInput(attrs={
            'class': 'form-control',
            'placeholder': 'Enter username or contact'
        })
    )
    password = forms.CharField(
        widget=forms.PasswordInput(attrs={
            'class': 'form-control',
            'placeholder': 'Enter password'
        })
    )

class RegisterForm(forms.ModelForm):
    password1 = forms.CharField(
        label='Password',
        widget=forms.PasswordInput(attrs={
            'class': 'form-control',
            'placeholder': 'Enter password'
        }),
        validators=[validate_password]
    )
    password2 = forms.CharField(
        label='Confirm Password',
        widget=forms.PasswordInput(attrs={
            'class': 'form-control',
            'placeholder': 'Confirm password'
        })
    )

    class Meta:
        model = Tenants
        fields = ['first_name', 'last_name', 'contacts', 'house_No']
        widgets = {
            'first_name': forms.TextInput(attrs={
                'class': 'form-control',
                'placeholder': 'Enter first name'
            }),
            'last_name': forms.TextInput(attrs={
                'class': 'form-control',
                'placeholder': 'Enter last name'
            }),
            'contacts': forms.TextInput(attrs={
                'class': 'form-control',
                'placeholder': 'Enter contact number'
            }),
            'house_No': forms.TextInput(attrs={
                'class': 'form-control',
                'placeholder': 'Enter house number'
            })
        }

    def clean(self):
        cleaned_data = super().clean()
        password1 = cleaned_data.get('password1')
        password2 = cleaned_data.get('password2')

        if password1 and password2 and password1 != password2:
            raise ValidationError("Passwords do not match")

        return cleaned_data

    def save(self, commit=True):
        # Save the provided password in hashed format
        user = super().save(commit=False)
        user.password = self.cleaned_data['password1']
        if commit:
            user.save()
        return user