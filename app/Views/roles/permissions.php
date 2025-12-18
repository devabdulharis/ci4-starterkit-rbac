<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex items-center gap-4 mb-6">
    <a href="/roles" class="btn btn-circle btn-ghost btn-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold">Update Permissions: <span class="text-primary"><?= esc($role['name']) ?></span></h1>
        <p class="text-base-content/60 text-sm">Select capabilities for this role</p>
    </div>
</div>

<div class="max-w-6xl mx-auto">
    <form action="/roles/permissions/update/<?= $role['id'] ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php 
                // Group permissions by module
                $groupedPermissions = [];
                foreach ($permissions as $permission) {
                    $parts = explode('.', $permission['name']);
                    $module = ucfirst($parts[0]);
                    $groupedPermissions[$module][] = $permission;
                }
            ?>

            <?php foreach ($groupedPermissions as $module => $perms): ?>
            <div class="card bg-base-100 shadow-lg border border-base-200 h-full">
                <div class="card-body p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="card-title text-lg"><?= $module ?></h3>
                        <div class="badge badge-neutral badge-sm"><?= count($perms) ?></div>
                    </div>
                    <div class="divider my-0"></div>
                    
                    <div class="space-y-3 mt-4">
                        <?php foreach ($perms as $permission): ?>
                        <div class="form-control">
                            <label class="label cursor-pointer justify-start gap-4 p-2 rounded-lg hover:bg-base-200/50 transition-colors">
                                <input type="checkbox" name="permissions[]" value="<?= $permission['id'] ?>" 
                                    class="checkbox checkbox-primary checkbox-sm"
                                    <?= in_array($permission['id'], $rolePermissions) ? 'checked' : '' ?> />
                                <div class="flex flex-col">
                                    <span class="font-medium text-sm"><?= esc($permission['name']) ?></span>
                                    <span class="text-xs text-base-content/60"><?= esc($permission['description']) ?></span>
                                </div>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="sticky bottom-6 bg-base-100/80 backdrop-blur-md shadow-2xl p-4 rounded-xl border border-base-200 mt-8 flex justify-between items-center z-20">
            <span class="text-sm font-medium">Review your changes before saving.</span>
            <div class="flex gap-2">
                <a href="/roles" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary px-8">Save Permissions</button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
