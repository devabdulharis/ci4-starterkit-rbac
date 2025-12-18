<!DOCTYPE html>
<html data-theme="emerald" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem RBAC | Starter Project</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            },
            daisyui: {
                themes: ["emerald", "dim"],
            },
        }
    </script>
    <script>
        // Theme Management
        document.addEventListener('DOMContentLoaded', () => {
            const themeController = document.querySelector('.theme-controller');
            const localTheme = localStorage.getItem('theme');
            const html = document.querySelector('html');
            
            // Apply saved theme
            if (localTheme) {
                html.setAttribute('data-theme', localTheme);
                if (localTheme === 'dim') {
                    themeController.checked = true;
                }
            }
            
            // Listen for toggle
            themeController.addEventListener('change', (e) => {
                const newTheme = e.target.checked ? 'dim' : 'emerald';
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            });
        });
    </script>
</head>
<body class="min-h-screen bg-base-200">

    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col min-h-screen">
            <!-- Navbar -->
            <div class="navbar bg-base-100/50 backdrop-blur-lg sticky top-0 z-30 border-b border-base-200">
                <div class="flex-none lg:hidden">
                    <label for="my-drawer-2" aria-label="open sidebar" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </label>
                </div>
                <div class="flex-1 px-4">
                    <div class="text-sm breadcrumbs">
                        <ul>
                            <li><a href="/dashboard">App</a></li>
                            <li class="font-semibold text-primary capitalize"><?= isset($title) ? $title : (uri_string() == '' ? 'Dashboard' : uri_string()) ?></li>
                        </ul>
                    </div>
                </div>
                <!-- Theme Toggle & Profile -->
                <div class="flex-none gap-2">
                    <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm">
                        <!-- this hidden checkbox controls the state -->
                        <input type="checkbox" class="theme-controller" value="dim" />
                        
                        <!-- sun icon -->
                        <svg class="swap-off fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>
                        
                        <!-- moon icon -->
                        <svg class="swap-on fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>
                    </label>

                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar <?php echo session()->get('avatar') ? '' : 'placeholder' ?>">
                            <div class="<?php echo session()->get('avatar') ? 'w-10 rounded-full' : 'bg-neutral text-neutral-content rounded-full w-10' ?>">
                                <?php if (session()->get('avatar')): ?>
                                    <img src="<?= base_url('uploads/avatars/' . session()->get('avatar')) ?>" alt="Avatar" />
                                <?php else: ?>
                                    <span><?= strtoupper(substr(session()->get('name') ?? 'U', 0, 2)) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                            <li><a href="/profile">Profile</a></li>
                            <li><a href="/logout" class="text-error">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-4 lg:p-8 max-w-7xl mx-auto w-full">
                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('message')): ?>
                    <div role="alert" class="alert alert-success mb-6 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span><?= session()->getFlashdata('message') ?></span>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div role="alert" class="alert alert-error mb-6 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span><?= session()->getFlashdata('error') ?></span>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-error mb-6 flex-col items-start shadow-sm">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span><?= $error ?></span>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </div>
            
            <footer class="footer footer-center p-4 bg-base-300 text-base-content mt-auto">
                <aside>
                    <p>Copyright © <?= date('Y') ?> - All rights reserved | <span class="badge badge-outline badge-sm">Rendered in {elapsed_time}</span></p>
                </aside>
            </footer>
        </div> 
        
        <!-- Sidebar -->
        <div class="drawer-side z-40">
            <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label> 
            <aside class="bg-base-100 min-h-full w-80 flex flex-col border-r border-base-200">
                <div class="p-6 pb-2">
                    <div class="flex items-center gap-3">
                        <div class="bg-primary/10 p-2 rounded-lg text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="font-bold text-xl tracking-tight">CI4 Starter</h1>
                            <p class="text-xs text-base-content/60">RBAC Management</p>
                        </div>
                    </div>
                </div>

                <div class="divider my-0"></div>

                <ul class="menu p-4 w-full text-base-content font-medium gap-1">
                    <!-- Dashboard -->
                    <li>
                        <a href="/dashboard" class="<?= url_is('dashboard') ? 'active !bg-primary !text-primary-content' : '' ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                            Dashboard
                        </a>
                    </li>
                    
                    <!-- Management Section -->
                    <li class="menu-title mt-4 text-xs font-bold uppercase text-base-content/50">Admin Controls</li>

                    <?php if (service('rbac')->hasPermission('users.view')): ?>
                    <li>
                        <a href="/users" class="<?= url_is('users*') ? 'active !bg-primary !text-primary-content' : '' ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                            Users
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if (service('rbac')->hasPermission('roles.view')): ?>
                    <li>
                        <a href="/roles" class="<?= url_is('roles*') ? 'active !bg-primary !text-primary-content' : '' ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                            Roles
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if (service('rbac')->hasPermission('permissions.view')): ?>
                    <li>
                        <a href="/permissions" class="<?= url_is('permissions*') ? 'active !bg-primary !text-primary-content' : '' ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
                            Permissions
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if (service('rbac')->hasRole('Super Admin') || service('rbac')->hasPermission('logs.view')): ?>
                    <li>
                        <a href="/logs" class="<?= url_is('logs*') ? 'active !bg-primary !text-primary-content' : '' ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            Activity Logs
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </aside>
        </div>
    </div>

</body>
</html>
