<?php

namespace App\Livewire\Transaction;

use App\Models\Transaction;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class Table extends DataTableComponent
{
    public $index = 0;

    #[On('refresh-table')]
    public function refresh(): void
    {
        $this->dispatch('refreshDatatable');
    }

    public function builder(): Builder
    {
        return Transaction::query()
            ->orderBy('created_at', 'desc')
            ->select();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        $this->index = 0;
        return [
            // Column::make("Id", "id")->format(function () {
            //     return ++$this->index + (($this->getPage() - 1) * json_encode($this->getPerPage()));
            // }),
            Column::make('Created At', 'created_at')
                ->searchable()
                ->sortable(),
            Column::make('Order ID', 'order_id')
                ->searchable()
                ->sortable(),
            Column::make('Amount', 'amount')
                ->searchable(),
            Column::make('Type', 'type')
                ->searchable(),
            Column::make('Status', 'status')
                ->searchable()
            ,
        ];
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Order ID')
                ->config([
                    'maxlength' => 10,
                    'placeholder' => 'Search order id',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('transactions.order_id', 'like', '%' . $value . '%');
                }),
        ];
    }
}
