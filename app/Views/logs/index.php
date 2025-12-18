<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-base-content">Activity Logs</h1>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body p-0">
            <div class="p-4 border-b border-base-200">
                <form action="" method="get" class="flex items-center gap-2 max-w-sm">
                    <label class="input input-bordered input-sm flex items-center gap-2 w-full">
                        <input type="text" name="search" class="grow" placeholder="Search logs..." value="<?= esc($search) ?>" />
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path fill-rule="evenodd" d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z" clip-rule="evenodd" /></svg>
                    </label>
                    <button type="submit" class="btn btn-sm btn-ghost">Search</button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Agent</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($logs)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-base-content/60">No activity logs found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($logs as $log): ?>
                                <tr class="hover">
                                    <td>
                                        <?php if(isset($log['user_name'])): ?>
                                            <div class="font-bold"><?= esc($log['user_name']) ?></div>
                                            <div class="text-xs opacity-50"><?= esc($log['user_email']) ?></div>
                                        <?php else: ?>
                                            <span class="italic text-base-content/50">System/Guest</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="badge badge-outline"><?= esc($log['action']) ?></div>
                                    </td>
                                    <td class="max-w-xs truncate" title="<?= esc($log['description']) ?>">
                                        <?= esc($log['description']) ?>
                                    </td>
                                    <td class="font-mono text-xs"><?= esc($log['ip_address']) ?></td>
                                    <td class="max-w-xs truncate text-xs text-base-content/60" title="<?= esc($log['user_agent']) ?>">
                                        <?= esc($log['user_agent']) ?>
                                    </td>
                                    <td class="text-sm">
                                        <?= date('M d, Y H:i:s', strtotime($log['created_at'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-base-200">
                <?= $pager->links('default', 'daisyui_pagination') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
