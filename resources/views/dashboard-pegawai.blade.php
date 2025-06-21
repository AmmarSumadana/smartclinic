@extends('layouts.template-pegawai') {{-- Using the new layout --}}

@section('title', 'Pegawai Dashboard SmartClinic')
@section('page-title', 'Main Employee Dashboard')

{{-- @push('head') and <style> section REMOVED because handled by layouts/template-pegawai --}}

@section('content')
<div class="p-6 md:p-8 lg:p-10"> {{-- Removed bg-gray-100 and min-h-screen as handled by layout --}}
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Hospital Employee Dashboard</h2>
        <p class="text-gray-600 text-base md:text-lg">Welcome back, {{ Auth::user()->name }}! Manage hospital data and services here.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card: Manage Consultations -->
        <div class="neumo-card-small p-6 animate__animated animate__fadeInUp">
            <div class="flex items-center gap-4 mb-4">
                <div class="icon-circle bg-blue-600">
                    <i class="fa-solid fa-comments"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Manage Consultations</h3>
            </div>
            <p class="text-gray-600 mb-4">View and handle consultation requests from patients.</p>
            <a href="{{ route('pegawai.consultations.index') }}" class="btn-custom-primary">
                <i class="fa-solid fa-arrow-right me-2"></i> Access Consultations
            </a>
        </div>

        <!-- Card: Manage Inpatient Care -->
        <div class="neumo-card-small p-6 animate__animated animate__fadeInUp animate__delay-0-5s">
            <div class="flex items-center gap-4 mb-4">
                <div class="icon-circle bg-green-600">
                    <i class="fa-solid fa-bed-pulse"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Manage Inpatient Care</h3>
            </div>
            <p class="text-gray-600 mb-4">Review and process patient inpatient registrations.</p>
            <a href="{{ route('pegawai.rawat-inap.index') }}" class="btn-custom-primary">
                <i class="fa-solid fa-arrow-right me-2"></i> Access Inpatient Care
            </a>
        </div>

        <!-- Card: Manage Doctors -->
        <div class="neumo-card-small p-6 animate__animated animate__fadeInUp animate__delay-1s">
            <div class="flex items-center gap-4 mb-4">
                <div class="icon-circle bg-purple-600">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Manage Doctor Data</h3>
            </div>
            <p class="text-gray-600 mb-4">Add, edit, or delete doctor data available at the hospital.</p>
            <a href="{{ route('pegawai.doctors.index') }}" class="btn-custom-primary"> {{-- Link to pegawai.doctors.index route --}}
                <i class="fa-solid fa-arrow-right me-2"></i> Manage Doctors
            </a>
        </div>

        <!-- Card: Manage Patient Data -->
        <div class="neumo-card-small p-6 animate__animated animate__fadeInUp animate__delay-1-5s">
            <div class="flex items-center gap-4 mb-4">
                <div class="icon-circle bg-red-600">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Manage Patient Data</h3>
            </div>
            <p class="text-gray-600 mb-4">View and manage patient information and medical history.</p>
            <a href="{{ route('pegawai.patients.index') }}" class="btn-custom-primary"> {{-- Link to pegawai.patients.index route --}}
                <i class="fa-solid fa-arrow-right me-2"></i> Manage Patients
            </a>
        </div>

        <!-- Card: Statistics & Reports -->
        <div class="neumo-card-small p-6 animate__animated animate__fadeInUp animate__delay-2s">
            <div class="flex items-center gap-4 mb-4">
                <div class="icon-circle bg-yellow-600">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Statistics & Reports</h3>
            </div>
            <p class="text-gray-600 mb-4">Access hospital operational reports and statistics.</p>
            <a href="{{ route('pegawai.reports.index') }}" class="btn-custom-primary"> {{-- Link to pegawai.reports.index route --}}
                <i class="fa-solid fa-arrow-right me-2"></i> View Reports
            </a>
        </div>

        <!-- Card: Profile Settings (changed from System Settings) -->
        <div class="neumo-card-small p-6 animate__animated animate__fadeInUp animate__delay-2-5s">
            <div class="flex items-center gap-4 mb-4">
                <div class="icon-circle bg-gray-600">
                    <i class="fa-solid fa-cog"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Profile Settings</h3>
            </div>
            <p class="text-gray-600 mb-4">Manage your personal profile and account settings.</p>
            <a href="{{ route('profile.edit') }}" class="btn-custom-primary"> {{-- Link to employee profile --}}
                <i class="fa-solid fa-arrow-right me-2"></i> Edit Profile
            </a>
        </div>

    </div>
</div>
@endsection
