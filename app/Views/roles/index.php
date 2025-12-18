<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold">Role Management</h1>
        <p class="text-base-content/60 text-sm">Define roles and access levels</p>
    </div>
    
    <div class="flex gap-2">
        <form action="" method="get" class="flex gap-2">
        <label class="input input-bordered flex items-center gap-2 h-8">
            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></g></svg>
            <input type="search" name="search" class="grow" placeholder="Search roles..." value="<?= esc($search) ?>" />
        </label>
        </form>
        
        <?php if (service('rbac')->hasPermission('roles.create')): ?>
        <a href="/roles/create" class="btn btn-primary btn-sm gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            Add Role
        </a>
        <?php endif; ?>
    </div>
</div>

<div class="card bg-base-100 shadow-sm border border-base-200">
    <div class="overflow-x-hidden">
        <table class="table w-full">
            <thead class="bg-base-200/50">
                <tr>
                    <th>
                        <label>
                            <input type="checkbox" class="checkbox checkbox-sm" />
                        </label>
                    </th>
                    <th>Role Name</th>
                    <th>Description</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $role): ?>
                <tr class="hover:bg-base-200/30 transition-colors">
                    <th>
                        <label>
                            <input type="checkbox" class="checkbox checkbox-sm" />
                        </label>
                    </th>
                    <td>
                        <div class="font-bold"><?= esc($role['name']) ?></div>
                    </td>
                    <td>
                        <span class="text-base-content/70"><?= esc($role['description']) ?></span>
                    </td>
                    <th class="text-right">
                        <div class="join">
                            <?php if (service('rbac')->hasPermission('roles.edit')): ?>
                            <a href="/roles/edit/<?= $role['id'] ?>" class="btn btn-ghost btn-xs join-item tooltip" data-tip="Edit Role">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                  <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                  <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                </svg>
                            </a>
                            <a href="/roles/permissions/<?= $role['id'] ?>" class="btn btn-ghost btn-xs join-item tooltip" data-tip="Manage Permissions">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                  <path fill-rule="evenodd" d="M9.493 2.853a.75.75 0 00-1.486-.205L7.545 6H4.198a.75.75 0 000 1.5h3.14l-1.286 5.9A.75.75 0 006.5 14h3.118l-3.51 9.423a.75.75 0 001.486.205L12.455 18h3.347a.75.75 0 000-1.5h-3.14l1.286-5.9a.75.75 0 00-.448-.908H10.382l3.51-9.423z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <?php endif; ?>
                            
                            <?php if (service('rbac')->hasPermission('roles.delete')): ?>
                            <a href="/roles/delete/<?= $role['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-ghost btn-xs join-item text-error tooltip" data-tip="Delete Role">
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
