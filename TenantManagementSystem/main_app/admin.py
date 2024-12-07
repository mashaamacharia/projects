
from django.contrib import admin
from .models import Tenants

@admin.register(Tenants)
class TenantsAdmin(admin.ModelAdmin):
    list_display = (
        'first_name', 'last_name', 'contacts',
        'house_No', 'total_rent', 'paid', 'deficit',
        'updated_at', 'created_at'
    )
    list_filter = ('created_at', 'updated_at', 'house_No')
    search_fields = ('first_name', 'last_name', 'contacts', 'house_No')
    ordering = ('-created_at',)
    list_editable = ('total_rent', 'paid', 'deficit')
    readonly_fields = ('created_at', 'updated_at')

