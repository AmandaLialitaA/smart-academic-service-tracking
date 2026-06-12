@extends('layouts.app')

@section('title', 'Halaman Analytics Dihapus')
@section('topbar_name', auth()->user()->name ?? 'Admin')
@section('topbar_role', ucfirst(auth()->user()->role ?? 'admin'))

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
<div class="page-wrapper" style="padding: 48px; max-width: 840px; margin: 0 auto;">
    <div style="border:2px solid #111; padding: 36px; background:#fff; box-shadow:0 12px 24px rgba(0,0,0,.06);">
        <h1 style="font-family: 'Barlow Condensed', sans-serif; font-size:36px; margin-bottom:16px;">Halaman Analytics Telah Dihapus</h1>
        <p style="font-size:15px; color:#444; line-height:1.75; margin-bottom:24px;">Fitur analytics sekarang sudah dirangkum dalam <strong>Dashboard Admin</strong>. Halaman ini tidak lagi digunakan untuk menjaga antarmuka admin tetap sederhana dan fokus.</p>
        <a href="/admin/dashboard" style="display:inline-block; padding:14px 22px; background:#111; color:#fff; text-decoration:none; font-weight:700;">Kembali ke Dashboard</a>
    </div>
</div>
@endsection