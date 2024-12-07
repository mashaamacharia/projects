from django.db import models
from django.core.validators import RegexValidator
from django.contrib.auth.hashers import make_password

class Tenants(models.Model):
    first_name = models.CharField(max_length=30)
    last_name = models.CharField(max_length=30)
    contacts = models.CharField(
        max_length=10,
        validators=[RegexValidator(r'^\d{10}$', 'Enter a valid 10-digit number.')]
    )
    house_No = models.CharField(max_length=5)
    password = models.CharField(max_length=128)  # No default hash here
    total_rent = models.CharField(max_length=6)
    paid = models.CharField(max_length=6)
    deficit = models.CharField(max_length=6)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        db_table = 'tenants'

    def save(self, *args, **kwargs):
        # Hash the password only if it's not already hashed
        if not self.pk or not self.password.startswith('pbkdf2_'):
            self.password = make_password(self.password)
        super().save(*args, **kwargs)














# from django.db import models
# from django.core.validators import RegexValidator
#
# # Create your models here.
# class Tenants(models.Model):
#     first_name= models.CharField(max_length=30)
#     last_name= models.CharField(max_length=30)
#     contacts = models.CharField(
#         max_length=10,
#         validators=[RegexValidator(r'^\d{10}$', 'Enter a valid 10-digit number.')]
#     )
#     house_No= models.CharField(max_length=5)
#     total_rent= models.CharField(max_length=6)
#     paid=models.CharField(max_length=6)
#     deficit = models.CharField(max_length=6)
#     created_at= models.DateTimeField(auto_now_add=True)
#     updated_at= models.DateTimeField(auto_now=True)
#
#     class Meta:
#         db_table='tenants'
#
