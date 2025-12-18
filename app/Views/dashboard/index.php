<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-8">
    <h1 class="text-3xl font-bold mb-2">Dashboard</h1>
    <p class="text-base-content/60">Overview of your application stats.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Stat 1: Role -->
     <div class="stats shadow-lg border border-base-200">
        <div class="stat">
            <div class="stat-figure text-primary">
                <div class="p-3 bg-primary/10 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
            </div>
            <div class="stat-title text-xs font-bold uppercase tracking-wide">Your Role</div>
            <div class="stat-value text-primary text-2xl mt-1">
                <?php 
                    $roles = (new \App\Models\UserModel())->getRoles(session()->get('user_id'));
                    echo !empty($roles) ? esc($roles[0]['name']) : 'User';
                ?>
            </div>
            <div class="stat-desc mt-2">Active access level</div>
        </div>
    </div>

    <!-- Stat 2: Total Users (Example data) -->
    <div class="stats shadow-lg border border-base-200">
        <div class="stat">
            <div class="stat-figure text-secondary">
                 <div class="p-3 bg-secondary/10 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                 </div>
            </div>
            <div class="stat-title text-xs font-bold uppercase tracking-wide">Total Users</div>
            <div class="stat-value text-secondary text-2xl mt-1"><?= (new \App\Models\UserModel())->countAllResults() ?></div>
            <div class="stat-desc mt-2">Registered accounts</div>
        </div>
    </div>
    
    <!-- Stat 3: Total Roles -->
    <div class="stats shadow-lg border border-base-200">
        <div class="stat">
            <div class="stat-figure text-accent">
                 <div class="p-3 bg-accent/10 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                 </div>
            </div>
            <div class="stat-title text-xs font-bold uppercase tracking-wide">Roles</div>
            <div class="stat-value text-accent text-2xl mt-1"><?= (new \App\Models\RoleModel())->countAllResults() ?></div>
            <div class="stat-desc mt-2">Defined roles</div>
        </div>
    </div>
</div>

<!-- Welcome Card -->
<div class="card bg-base-100 shadow-xl image-full h-64 mb-8 overflow-hidden">
  <figure><img src="https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2629&auto=format&fit=crop" alt="Background" class="object-cover w-full opacity-50" /></figure>
  <div class="card-body justify-center items-start">
    <h2 class="card-title text-3xl font-bold text-white mb-2">Welcome Back, <?= esc(session()->get('name')) ?>!</h2>
    <p class="text-white/80 max-w-lg">This is your project dashboard. Manage users, roles, and permissions from the sidebar menu.</p>
    <div class="card-actions justify-end mt-4">
        <?php if (service('rbac')->hasPermission('users.create')): ?>
        <a href="/users/create" class="btn btn-primary border-none">Add New User</a>
        <?php endif; ?>
    </div>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="card bg-base-100 shadow-lg border border-base-200">
        <div class="card-body">
             <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                System Info
             </h3>
             <div class="overflow-x-hidden">
                <table class="table table-sm">
                    <tbody>
                        <tr><th>Framework</th><td>CodeIgniter <?= CodeIgniter\CodeIgniter::CI_VERSION ?></td></tr>
                        <tr><th>Environment</th><td><span class="badge badge-outline badge-sm uppercase"><?= ENVIRONMENT ?></span></td></tr>
                        <tr><th>PHP Version</th><td><?= phpversion() ?></td></tr>
                        <tr><th>Database</th><td>MySQL</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card bg-base-100 shadow-lg border border-base-200">
        <div class="card-body">
             <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>
                Quick Links
             </h3>
             <div class="grid grid-cols-2 gap-4">
                <?php if (service('rbac')->hasPermission('users.view')): ?>
                <a href="/users" class="btn btn-outline btn-neutral h-auto py-4 flex flex-col gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    Manage Users
                </a>
                <?php endif; ?>
                
                <?php if (service('rbac')->hasPermission('roles.view')): ?>
                <a href="/roles" class="btn btn-outline btn-neutral h-auto py-4 flex flex-col gap-2">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                    Manage Roles
                </a>
                <?php endif; ?>
             </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
