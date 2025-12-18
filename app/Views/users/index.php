<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold">User Management</h1>
        <p class="text-base-content/60 text-sm">Manage system access and accounts</p>
    </div>
    
    <div class="flex gap-2">
        <form action="" method="get" class="flex gap-2">
        <label class="input input-bordered flex items-center gap-2 h-8">
            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></g></svg>
            <input type="search" name="search" class="grow" placeholder="Search users..." value="<?= esc($search) ?>" />
        </label>
        </form>
        
        <?php if (service('rbac')->hasPermission('users.create')): ?>
        <a href="/users/create" class="btn btn-primary btn-sm gap-2">
             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            Add User
        </a>
        <?php endif; ?>
    </div>
</div>

<div class="card bg-base-100 shadow-sm border border-base-200">
    <div class="overflow-x-hidden">
        <table class="table w-full">
            <!-- head -->
            <thead class="bg-base-200/50">
                <tr>
                    <th>
                        <label>
                            <input type="checkbox" class="checkbox checkbox-sm" />
                        </label>
                    </th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr class="hover:bg-base-200/30 transition-colors">
                    <th>
                        <label>
                            <input type="checkbox" class="checkbox checkbox-sm" />
                        </label>
                    </th>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="avatar placeholder">
                                <div class="bg-neutral text-neutral-content rounded-full w-10">
                                    <span class="text-xs"><?= strtoupper(substr($user['name'], 0, 2)) ?></span>
                                </div>
                            </div>
                            <div>
                                <div class="font-bold"><?= esc($user['name']) ?></div>
                                <div class="text-sm opacity-50"><?= esc($user['email']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php 
                            $userRoles = (new \App\Models\UserModel())->getRoles($user['id']);
                            if (!empty($userRoles)): 
                                foreach($userRoles as $role):
                        ?>
                            <span class="badge badge-ghost badge-sm"><?= esc($role['name']) ?></span>
                        <?php 
                                endforeach;
                            else: 
                        ?>
                            <span class="text-base-content/40 text-sm italic">No role</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($user['is_active']): ?>
                            <div class="badge badge-success gap-2 badge-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                Active
                            </div>
                        <?php else: ?>
                            <div class="badge badge-error gap-2 badge-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                Inactive
                            </div>
                        <?php endif; ?>
                    </td>
                    <th class="text-right">
                        <div class="join">
                            <?php if (service('rbac')->hasPermission('users.edit')): ?>
                            <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-ghost btn-xs join-item tooltip" data-tip="Edit User">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                  <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                  <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                </svg>
                            </a>
                            <a href="/users/roles/<?= $user['id'] ?>" class="btn btn-ghost btn-xs join-item tooltip" data-tip="Manage Roles">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                  <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <?php endif; ?>
                            
                            <?php if (service('rbac')->hasPermission('users.delete')): ?>
                            <a href="/users/delete/<?= $user['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-ghost btn-xs join-item text-error tooltip" data-tip="Delete User">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                  <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <?php endif; ?>
                        </div>
                    </th>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-base-200 flex justify-center">
        <?= $pager->links('default', 'daisyui_pagination') ?>
    </div>
</div>

<?= $this->endSection() ?>
