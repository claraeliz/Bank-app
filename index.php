<?php
require_once 'includes/bootstrap.php';

// Handle account selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['select_account'])) {
    $idx = (int) $_POST['select_account'];
    if (isset($accounts[$idx])) {
        $_SESSION['selected_idx'] = $idx;
        $selectedIdx = $idx;
        $account     = $accounts[$idx];
        $card        = $cards[$idx];
    }
}

require_once 'includes/header.php';
?>

<?php if ($selectedIdx === null): ?>

    <!-- Account Picker -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Choose an Account</h1>
        <p class="text-slate-500 mt-1">Select which account you want to manage.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php foreach ($accounts as $idx => $acc): ?>
            <form method="POST">
                <input type="hidden" name="select_account" value="<?= $idx ?>">
                <button type="submit" class="w-full text-left bg-white rounded-2xl shadow p-6 hover:shadow-md hover:ring-2 hover:ring-violet-400 transition cursor-pointer">
                    <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Account <?= $idx + 1 ?></p>
                    <p class="text-xl font-bold text-slate-800"><?= htmlspecialchars($acc->getOwner()->getName()) ?></p>
                    <p class="text-sm text-slate-400 mt-1"><?= htmlspecialchars($acc->getOwner()->getEmail()) ?></p>
                    <div class="mt-4 inline-block bg-violet-600 text-white text-sm font-semibold px-4 py-2 rounded-xl">
                        Select
                    </div>
                </button>
            </form>
        <?php endforeach; ?>
    </div>

<?php else: ?>

    <!-- Dashboard -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Welcome back, <?= htmlspecialchars($account->getOwner()->getName()) ?>
            </h1>
            <p class="text-slate-500 mt-1"><?= date('l, d F Y') ?></p>
        </div>
        <a href="switch_account.php"
           class="text-sm text-slate-500 hover:text-slate-800 border border-slate-200 px-4 py-2 rounded-xl transition">
            &#8644; Switch Account
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <!-- Balance Card -->
        <div class="bg-slate-900 text-white rounded-2xl p-6 shadow">
            <p class="text-slate-400 text-sm mb-1">Available Balance</p>
            <p class="text-4xl font-bold">€<?= number_format($account->getBalance(), 2) ?></p>
            <p class="text-slate-400 text-sm mt-4"><?= htmlspecialchars($account->getOwner()->getEmail()) ?></p>
        </div>

        <!-- Debit Card -->
        <div class="bg-gradient-to-br from-violet-600 to-indigo-600 text-white rounded-2xl p-6 shadow flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <p class="text-sm font-semibold tracking-widest uppercase">Debit</p>
                <span class="text-xs px-2 py-1 rounded-full <?= $card->isActive() ? 'bg-green-400 text-green-900' : 'bg-red-400 text-red-900' ?> font-semibold">
                    <?= $card->isActive() ? 'Active' : 'Frozen' ?>
                </span>
            </div>
            <div>
                <p class="text-lg tracking-widest font-mono mt-4">
                    **** **** **** <?= substr($card->getCardNumber(), -4) ?>
                </p>
                <div class="flex justify-between text-xs text-indigo-200 mt-2">
                    <span><?= htmlspecialchars($account->getOwner()->getName()) ?></span>
                    <span>Exp: <?= $card->getExpiryDate() ?></span>
                </div>
            </div>
            <div class="flex gap-3 mt-4">
                <a href="<?= $card->isActive() ? 'freeze.php' : 'unfreeze.php' ?>"
                   class="text-xs bg-white/20 hover:bg-white/30 transition px-3 py-1 rounded-full">
                    <?= $card->isActive() ? 'Freeze Card' : 'Unfreeze Card' ?>
                </a>
            </div>
        </div>

    </div>

    <!-- Transaction History -->
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Transaction History</h2>

        <?php $transactions = $account->getTransactions(); ?>

        <?php if (empty($transactions)): ?>
            <p class="text-slate-400 text-sm">No transactions yet.</p>
        <?php else: ?>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-400 border-b">
                        <th class="pb-2">Type</th>
                        <th class="pb-2">Amount</th>
                        <th class="pb-2">Details</th>
                        <th class="pb-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_reverse($transactions) as $t): ?>
                        <?php if ($t instanceof Transfer): ?>
                            <?php
                                $isOutgoing = $t->getFromAccount()->getOwner()->getName() === $account->getOwner()->getName();
                            ?>
                            <tr class="border-b border-slate-50">
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $isOutgoing ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' ?>">Transfer</span>
                                </td>
                                <td class="py-3 font-semibold <?= $isOutgoing ? 'text-blue-600' : 'text-green-600' ?>">
                                    <?= $isOutgoing ? '-' : '+' ?>€<?= number_format($t->getAmount(), 2) ?>
                                </td>
                                <td class="py-3 text-slate-500">
                                    <?= $isOutgoing
                                        ? 'To: ' . htmlspecialchars($t->getToAccount()->getOwner()->getName())
                                        : 'From: ' . htmlspecialchars($t->getFromAccount()->getOwner()->getName()) ?>
                                </td>
                                <td class="py-3 text-slate-400"><?= $t->getTimestamp() ?></td>
                            </tr>
                        <?php else: ?>
                            <tr class="border-b border-slate-50">
                                <td class="py-3">
                                    <?php if ($t->getType() === 'deposit'): ?>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Deposit</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Withdraw</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 font-semibold <?= $t->getType() === 'deposit' ? 'text-green-600' : 'text-red-500' ?>">
                                    <?= $t->getType() === 'deposit' ? '+' : '-' ?>€<?= number_format($t->getAmount(), 2) ?>
                                </td>
                                <td class="py-3 text-slate-400">—</td>
                                <td class="py-3 text-slate-400"><?= $t->getTimestamp() ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
