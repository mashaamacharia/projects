# Generated by Django 5.1.3 on 2024-11-29 06:59

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('main_app', '0001_initial'),
    ]

    operations = [
        migrations.AddField(
            model_name='tenants',
            name='password',
            field=models.CharField(default='pbkdf2_sha256$870000$N884QuZfy9wKp7puk9I9uY$c68wHSO91m3igAbg7nNO47jrTWW84sLgjUVUp4kkk3o=', max_length=128),
        ),
    ]