<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OrdersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('id', function (Order $order) {
                return '<button class="btn btn-sm btn-light" onclick="copyToClipboard(\'' . $order->id . '\')" title="' . $order->id . '">
                        ' . substr($order->id, 0, 8) . '... <i class="fas fa-copy"></i>
                    </button>';
            })
            ->editColumn('title', function (Order $order) {
                return view('pages/apps.orders.columns._order', compact('order'));
            })
            ->editColumn('details', function (Order $order) {
                $truncatedDetails = \Str::limit($order->details, 50, '...');
                return '<span title="' . e($order->details) . '">' . e($truncatedDetails) . '</span>';
            })
            ->editColumn('created_at', function (Order $order) {
                return $this->formatDate($order->created_at);
            })
            ->editColumn('status', function (Order $order) {
                return sprintf('<span class="badge badge-%s fw-bold">%s</span>', $this->getStatusColor($order->status), $order->status);
            })
            ->addColumn('requirements', function (Order $order) {
                $totalRequirements = $order->requirements->count();
                $completedRequirements = $order->requirements->where('status', 'مكتمل')->count();
                $remainingRequirements = $totalRequirements - $completedRequirements;
                return sprintf(
                    '<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#requirementsModal" data-requirements="%s" data-order-status="%s">
                        %d/%d المتبقي %d
                    </button>',
                    e(json_encode($order->requirements)),
                    e($order->status),
                    $completedRequirements,
                    $totalRequirements,
                    $remainingRequirements
                );
            })
            ->addColumn('attachments', function (Order $order) {
                $attachments = $order->attachments;
                if ($attachments->isEmpty()) {
                    return '<span class="text-muted">لا توجد مرفقات</span>';
                }
                $list = '<ul class="list-attachments">';
                foreach ($attachments as $attachment) {
                    $list .= sprintf(
                        '<li class="attachment-item"><a href="%s" target="_blank">%s</a></li>',
                        e(route('attachments.download', $attachment->id)),
                        e($attachment->file_name)
                    );
                }
                $list .= '</ul>';
                return $list;
            })
            ->addColumn('action', function (Order $order) {
                return view('pages/apps.orders.columns._actions', compact('order'));
            })
            ->rawColumns(['id', 'status', 'action', 'requirements', 'attachments', 'created_at', 'details']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        $query = $model->newQuery();

        // فلترة حسب الحالة
        $status = request()->get('status', 'غير منجز'); // القيمة الافتراضية "غير منجز"

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // فلترة التواريخ
        if (request()->has('start_date') && request()->has('end_date')) {
            $startDate = request()->get('start_date');
            $endDate = request()->get('end_date');

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            }
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('orders-table')
            ->columns($this->getColumns())
            ->minifiedAjax('', null, [
                'start_date' => 'function() { return document.getElementById("start_date").value; }',
                'end_date' => 'function() { return document.getElementById("end_date").value; }',
                'status' => 'function() { return document.getElementById("status_filter").value; }'
            ])
            ->dom('rt<"row"<"col-sm-12"tr>><"d-flex justify-content-between"<"col-sm-12 col-md-5"i><"d-flex justify-content-between"p>>')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(4)
            ->drawCallback('function() {' . file_get_contents(resource_path('views/pages/apps/orders/columns/_draw-scripts.js')) . '}')
            ->parameters([
                'language' => [
                    'url' => asset('js/datatables/ar.json')
                ],
                'columnDefs' => [
                    ['className' => 'text-center', 'targets' => '_all']
                ]
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title(__('الرقم التعريفي'))->addClass('text-center'),
            Column::make('order_number')->title(__('رقم الطلب'))->addClass('text-center'),
            Column::make('title')->title(__('العنوان'))->addClass('text-center'),
            Column::make('details')->title(__('التفاصيل'))->addClass('text-center'),
            Column::make('status')->title(__('الحالة'))->addClass('text-center'),
            Column::make('created_at')->title(__('تاريخ الإنشاء'))
                ->addClass('text-center')
                ->render('function() { return data; }'),
            Column::make('requirements')->title(__('المتطلبات'))->addClass('text-center'),
            Column::make('attachments')->title(__('المرفقات'))->addClass('text-center'),
            Column::computed('action')
                ->title(__('الإجراءات'))
                ->addClass('text-center')
                ->exportable(false)
                ->printable(false)
                ->width(60),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Orders_' . date('YmdHis');
    }

    private function getStatusColor(string $status): string
    {
        return match ($status) {
            'معلق' => 'warning',
            'غير مجز' => 'info',
            'مكتمل' => 'success',
            'ملغي' => 'danger',
            default => 'secondary',
        };
    }

    private function formatDate($date)
    {
        if (!$date) {
            return 'لم يحدد';
        }

        $carbonDate = Carbon::parse($date);
        $arabicDate = $carbonDate->locale('ar')->isoFormat('DD MMMM YYYY');
        $timeAgo = $carbonDate->diffForHumans();

        return '<span title="' . $arabicDate . '">' . $timeAgo . '</span>';
    }
}
