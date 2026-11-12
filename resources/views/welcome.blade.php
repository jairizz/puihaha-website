@extends('layouts.app')

@section('content')
<div class="login-page"><div class="login-decoration"><div class="login-brand"><span class="brand-mark">P</span><div><strong>Puihaha</strong><small>Membership operations</small></div></div><div class="login-message"><span class="eyebrow eyebrow-light">MEMBERSHIP MANAGEMENT SYSTEM</span><h1>Everything your membership office needs in one place.</h1><p>Manage member records, membership plans, transactions, and payments with clarity.</p></div></div><div class="login-card"><span class="eyebrow">READY TO BEGIN?</span><h1>Open your workspace</h1><p class="login-subtitle">Sign in to manage your membership operations.</p><a href="{{ route('login') }}" class="primary-btn login-btn">Go to sign in <i class="fa-solid fa-arrow-right"></i></a></div></div>
@endsection
