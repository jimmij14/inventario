@extends('layouts.admin')

@section('content')
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Escritorio !</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <li class="breadcrumb-item"><a href="#">sisInventario</a></li>
                                            <li class="breadcrumb-item"><a href="#">UDEA</a></li>
                                            <li class="breadcrumb-item active">Escritorio</li>
                                        </ol>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-3 col-sm-6">
                                <div class="card bg-pink">
                                    <div class="card-body widget-style-2">
                                        <div class="text-white media">
                                            <div class="media-body align-self-center">
                                                <h2 class="my-0 text-white"><span data-plugin="counterup">{{ $totalEquipos }}</span></h2>
                                                <p class="mb-0">Total Equipos</p>
                                            </div>
                                            <i class="ion-md-eye"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-6">
                                <div class="card bg-purple">
                                    <div class="card-body widget-style-2">
                                        <div class="text-white media">
                                            <div class="media-body align-self-center">
                                                <h2 class="my-0 text-white"><span data-plugin="counterup">{{ $totalAreas }}</span></h2>
                                                <p class="mb-0">Total Áreas</p>
                                            </div>
                                            <i class="ion-md-paper-plane"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-6">
                                <div class="card bg-info">
                                    <div class="card-body widget-style-2">
                                        <div class="text-white media">
                                            <div class="media-body align-self-center">
                                                <h2 class="my-0 text-white"><span data-plugin="counterup">{{ $totalPersonal }}</span></h2>
                                                <p class="mb-0">Total Personal</p>
                                            </div>
                                            <i class="ion-ios-pricetag"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-6">
                                <div class="card bg-primary">
                                    <div class="card-body widget-style-2">
                                        <div class="text-white media">
                                            <div class="media-body align-self-center">
                                                <h2 class="my-0 text-white"><span data-plugin="counterup">{{ $totalMovimientos }}</span></h2>
                                                <p class="mb-0">Total Movimientos</p>
                                            </div>
                                            <i class="mdi mdi-comment-multiple"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
@endsection