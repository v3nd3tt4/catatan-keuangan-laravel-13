<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #6366f1;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #6366f1;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }
        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .info-block {
            width: 30%;
        }
        .info-block strong {
            display: block;
            color: #6366f1;
        }

        .summary {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .summary-item {
            text-align: center;
            flex: 1;
        }
        .summary-item label {
            display: block;
            font-size: 11px;
            color: #666;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .summary-item .value {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .summary-item.income .value {
            color: #10b981;
        }
        .summary-item.expense .value {
            color: #ef4444;
        }
        .summary-item.balance .value {
            color: #6366f1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }
        thead {
            background-color: #f3f4f6;
        }
        th {
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #d1d5db;
            color: #333;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        tr:last-child td {
            border-bottom: 2px solid #d1d5db;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }

        .category-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .category-title {
            font-size: 13px;
            font-weight: bold;
            color: #6366f1;
            margin-bottom: 10px;
            border-left: 3px solid #6366f1;
            padding-left: 10px;
        }
        .category-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .category-table th,
        .category-table td {
            padding: 6px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .category-table th {
            background-color: #f9fafb;
            font-weight: bold;
            border-bottom: 1px solid #d1d5db;
        }

        .income {
            color: #10b981;
            font-weight: bold;
        }
        .expense {
            color: #ef4444;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-income {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-expense {
            background-color: #fee2e2;
            color: #7f1d1d;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #d1d5db;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
        .footer p {
            margin: 3px 0;
        }

        @media print {
            body {
                margin: 0;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>💰 Laporan Transaksi Keuangan</h1>
        <p>Finance App - {{ config('app.name') }}</p>
    </div>

    <div class="info">
        <div class="info-block">
            <strong>Nama Pengguna:</strong>
            <p>{{ $user->name }}</p>
        </div>
        <div class="info-block">
            <strong>Email:</strong>
            <p>{{ $user->email }}</p>
        </div>
        <div class="info-block">
            <strong>Periode Laporan:</strong>
            <p>{{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
        </div>
    </div>

    <div class="summary">
        <div class="summary-item income">
            <label>Total Pemasukan</label>
            <div class="value">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
        </div>
        <div class="summary-item expense">
            <label>Total Pengeluaran</label>
            <div class="value">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
        </div>
        <div class="summary-item balance">
            <label>Saldo</label>
            <div class="value" style="color: {{ $balance >= 0 ? '#10b981' : '#ef4444' }}">
                Rp {{ number_format(abs($balance), 0, ',', '.') }}
            </div>
        </div>
    </div>

    <h2 style="font-size: 14px; color: #333; margin-top: 30px; margin-bottom: 15px;">📋 Daftar Transaksi Lengkap</h2>
    
    @if($transactions->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Tipe</th>
                    <th>Keterangan</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date->format('d M Y') }}</td>
                        <td>{{ $transaction->category->name }}</td>
                        <td class="text-center">
                            <span class="badge {{ $transaction->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                                {{ $transaction->type === 'income' ? 'Masuk' : 'Keluar' }}
                            </span>
                        </td>
                        <td>{{ $transaction->description ?? '-' }}</td>
                        <td class="text-right {{ $transaction->type === 'income' ? 'income' : 'expense' }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 20px; color: #999;">
            <p>Tidak ada transaksi dalam periode ini</p>
        </div>
    @endif

    @if($byCategory->count() > 0)
        <div class="category-section">
            <div class="category-title">📊 Rincian per Kategori</div>
            
            @foreach($byCategory as $item)
                <div style="margin-bottom: 15px;">
                    <p style="margin: 0 0 5px 0; font-size: 12px; font-weight: bold; color: #333;">
                        {{ $item['category'] }}
                        <span class="badge {{ $item['type'] === 'income' ? 'badge-income' : 'badge-expense' }}">
                            {{ $item['type'] === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
                    </p>
                    <table class="category-table">
                        <tr>
                            <td><strong>Total:</strong></td>
                            <td style="text-align: right;" class="{{ $item['type'] === 'income' ? 'income' : 'expense' }}">
                                Rp {{ number_format($item['total'], 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Jumlah Transaksi:</strong></td>
                            <td style="text-align: right;">{{ $item['count'] }} transaksi</td>
                        </tr>
                        <tr>
                            <td><strong>Rata-rata:</strong></td>
                            <td style="text-align: right;">Rp {{ number_format($item['total'] / $item['count'], 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            @endforeach
        </div>
    @endif

    <div class="footer">
        <p><strong>Laporan Dibuat:</strong> {{ now()->format('d M Y H:i') }}</p>
        <p>Dokumen ini dibuat secara otomatis oleh Finance App</p>
    </div>
</body>
</html>
