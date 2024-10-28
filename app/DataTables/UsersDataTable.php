<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Carbon\Carbon;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'user', 'created_at', 'last_login_at', 'phone'])
            ->editColumn('phone', function (User $user) {
                return $user->phone ?? 'لا يوجد';
            })
            ->editColumn('user', function (User $user) {
                return view('pages/apps.user-management.users.columns._user', compact('user'));
            })
            ->editColumn('role', function (User $user) {
                return ucwords($user->roles->first()?->name);
            })
            ->editColumn('created_at', function (User $user) {
                return $this->formatDate($user->created_at);
            })
            ->editColumn('last_login_at', function (User $user) {
                return $this->formatDate($user->last_login_at);
            })
            ->addColumn('action', function (User $user) {
                return view('pages/apps.user-management.users.columns._actions', compact('user'));
            })
            ->setRowId('id');
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

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1) // تغيير الترتيب الافتراضي إلى العمود الأول (user) بدلاً من role
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/user-management/users/columns/_draw-scripts.js')) . "}")
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
            Column::make('user')->addClass('d-flex align-items-center')->name('name')->title(__('المستخدم')),
            Column::make('phone')->title(__('رقم الهاتف'))->addClass('text-center'),
            Column::make('role')->searchable(false)->title(__('الدور')),
            Column::make('last_login_at')->title(__('آخر تسجيل دخول'))->addClass('text-center'),
            Column::make('created_at')->title(__('تاريخ الانضمام'))->addClass('text-center'),
            Column::computed('action')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->title(__('الإجراءات'))
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
