<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::resource('cash-books', 'CashBookController');
    Route::resource('bank-accounts', 'BankAccountController');
    Route::resource('bank-reconciliation', 'BankReconciliationController');
    Route::resource('product-reconciliation', 'ProductReconciliationController');
    Route::resource('reports', 'ReportController');
    Route::resource('queue-journals', 'QueueJournalController');
    Route::resource('general-journals', 'GeneralJournalController');
    Route::resource('ledger', 'LedgerController');
    Route::resource('trial-balance', 'TrialBalanceController');
    Route::resource('reconciliation', 'ReconciliationController');
    Route::resource('closing-period', 'ClosingPeriodController');
    Route::resource('accounting-reports', 'AccountingReportController');
    Route::resource('chart-of-accounts', 'ChartOfAccountController');
    Route::resource('funding-sources', 'FundingSourceController');
    Route::resource('transaction-types', 'TransactionTypeController');
    Route::resource('payment-types', 'PaymentTypeController');
    Route::resource('organizational-units', 'OrganizationalUnitController');
    Route::resource('accounting-periods', 'AccountingPeriodController');
    Route::resource('users', 'UserController');
    Route::resource('integrations', 'IntegrationController');
});
