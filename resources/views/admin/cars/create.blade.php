@extends('layouts.admin_layout')

@section('title', 'Добавить машину')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Добавить машину</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="col-lg-12">
                <div class="card card-primary">

                    <!-- form start -->
                    <form action="{{route('cars.store')}}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="company">Компания</label>
                                <input type="text" name="company" class="form-control" id="company" placeholder="Компания" >
                            </div>
                            <div class="form-group">
                                <label for="name">Модель автомобиля</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Модель автомобиля" >
                            </div>
                            <div class="form-group">
                                <label for="vin">Vin-номер</label>
                                <input type="text" name="vin" class="form-control" id="vin" placeholder="Vin-номер" >
                            </div>
                            <div class="form-group">
                                <label for="registration">Регистрационный номер автомобиля</label>
                                <input type="text" name="registration" class="form-control" id="registration" placeholder="Регистрационный номер автомобиля" >
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endSection
