<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex items-center gap-4 mb-6">
    <a href="/users" class="btn btn-circle btn-ghost btn-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
    </a>
    <h1 class="text-2xl font-bold">Edit User</h1>
</div>

<div class="max-w-4xl mx-auto">
    <form action="/users/update/<?= $user['id'] ?>" method="post" class="card bg-base-100 shadow-xl border border-base-200">
        <div class="card-body">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Full Name</span>
                    </label>
                    <input type="text" name="name" class="input input-bordered focus:input-primary transition-all" required value="<?= old('name', $user['name']) ?>" />
                </div>

                <!-- Email -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Email Address</span>
                    </label>
                    <input type="email" name="email" class="input input-bordered focus:input-primary transition-all" required value="<?= old('email', $user['email']) ?>" />
                </div>

                <!-- Password -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Password</span>
                    </label>
                    <input type="password" name="password" class="input input-bordered focus:input-primary transition-all" placeholder="••••••••" />
                    <label class="label">
                        <span class="label-text-alt text-base-content/60">Leave blank to keep current password</span>
                    </label>
                </div>

                <!-- Status -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Account Status</span>
                    </label>
                    <div class="flex items-center gap-4 p-3 border rounded-lg hover:border-primary cursor-pointer transition-colors bg-base-200/30">
                        <input type="checkbox" name="is_active" class="toggle toggle-primary" value="1" <?= $user['is_active'] ? 'checked' : '' ?> />
                        <div class="flex flex-col">
                            <span class="font-medium">Active Account</span>
                            <span class="text-xs text-base-content/60">User can log in to the system</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-actions justify-end mt-8 pt-6 border-t border-base-200">
                <a href="/users" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary px-8">Save Changes</button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
