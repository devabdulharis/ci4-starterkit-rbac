<!DOCTYPE html>
<html data-theme="emerald" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CI4 Starter</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-base-200 flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Background Decoration -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-primary/20 rounded-full blur-3xl"></div>
    <div class="absolute top-20 right-20 w-72 h-72 bg-secondary/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-20 left-1/2 w-80 h-80 bg-accent/10 rounded-full blur-3xl"></div>

    <div class="card w-full max-w-sm bg-base-100/80 backdrop-blur-md shadow-2xl border border-base-200">
        <div class="card-body">
            <div class="text-center mb-6">
                <div class="bg-primary/10 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold">Welcome Back</h2>
                <p class="text-sm text-base-content/60">Enter your credentials to access your account</p>
            </div>
            
            <?php if (session()->getFlashdata('message')): ?>
                <div role="alert" class="alert alert-success text-sm py-2 px-3 mb-2 rounded-lg text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-4 w-4" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span><?= session()->getFlashdata('message') ?></span>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div role="alert" class="alert alert-error text-sm py-2 px-3 mb-2 rounded-lg text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-4 w-4" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Email</span>
                    </label>
                    <div class="relative">
                        <input type="email" name="email" placeholder="admin@admin.com" class="input input-bordered w-full pl-10 focus:input-primary transition-all" required value="<?= old('email') ?>" />
                        <span class="absolute left-3 top-3.5 text-base-content/40">
                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                              <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                              <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="form-control w-full mt-4">
                    <label class="label">
                        <span class="label-text font-medium">Password</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" placeholder="••••••••" class="input input-bordered w-full pl-10 focus:input-primary transition-all" required />
                        <span class="absolute left-3 top-3.5 text-base-content/40">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                              <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                    <label class="label">
                         <a href="/forgot-password" class="label-text-alt link link-primary hover:no-underline">Forgot password?</a>
                    </label>
                </div>

                <div class="card-actions mt-6">
                    <button class="btn btn-primary w-full shadow-lg shadow-primary/30">Sign In</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
