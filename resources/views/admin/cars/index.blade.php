@extends('layouts.admin_layout')

@section('title', 'Список машин')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Список машин</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="col-lg-12">
                <div class="card card-primary">

                    <div class="card">

                        <div class="card-body p-0">
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th style="width: 5% ">
                                        id
                                    </th>
                                    <th style="width: 10%">
                                        Название
                                    </th>
                                    <th style="width: 5% ">
                                        Компания
                                    </th>
                                    <th style="width: 5%">
                                        Модель
                                    </th>
                                    <th style="width: 10%">
                                        VIN-номер
                                    </th>
                                    <th style="width: 10%">
                                        Рег. номер
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cars as $car)
                                    <tr >
                                        <td style="width: 20%">{{ $car['id'] }} </td>

                                        <td style="width: 15%">{{ $car['name'] }} - {{ $car->properties->where('name', 'VehicleRegNumber')->first()->value }} </td>

                                        <td style="width: 10%">{{ $car['company'] }} </td>

                                        <td style="width: 10%">{{ $car['name'] }} </td>

                                        <td style="width: 15%">{{ $car->properties->where('name', 'vin')->first()->value }} </td>

                                        <td style="width: 10%">{{ $car->properties->where('name', 'VehicleRegNumber')->first()->value }} </td>


                                        <td class="project-actions text-right">
                                            <a class="btn btn-info btn-sm" href="{{route('cars.edit', $car['id'])}}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                                Редактировать
                                            </a>
                                            <form action="{{route('cars.destroy', $car['id'])}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn" >
                                                <i class="fas fa-trash">
                                                </i>
                                                Удалить
                                            </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endSection
