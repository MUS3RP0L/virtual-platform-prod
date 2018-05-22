@extends('globalprint.wkhtml')
@section('title')

@endsection
@section('content')
<table >
    <tr>
        <th colspan="9">Titular </th>
        <th colspan="10">Derechohabiente </th>
    </tr>
    <tr>
       <th>CI </th>
       <th>Genero</th>
       <th>Primer Nombre </th>
       <th>Segundo Nombre </th>
       <th>Apellido Paterno </th>
       <th>Apellido Materno </th>
       <th>Apellido Casada </th>
       <th>Fecha de nacimiento </th>
       <th>Codigo Nua Cua </th>
       <th>CI</th>
       <th>Ext</th>
       <th>Primer Nombre </th>
       <th>Segundo Nombre </th>
       <th>Apellido Paterno </th>
       <th>Apellido Materno </th>
       <th>Apellido Casada </th>
       <th>Fecha de Nacimiento </th>
       <th>Codigo del Afiliado </th>
       <th>Ciudad </th>
    </tr>
    @foreach($data as $obj)
    <tr>
        <td>{{ $obj->ci_causahabiente }}</td>
        <td>{{ $obj->genero }}</td>
        <td>{{ $obj->primer_nombre_causahabiente }}</td>
        <td>{{ $obj->segundo_nombre_causahabiente }}</td>
        <td>{{ $obj->ap_paterno_causahabiente }}</td>
        <td>{{ $obj->ap_materno_causahabiente }}</td>
        <td>{{ $obj->ape_casada_causahabiente }}</td>
        <td>{{ $obj->fecha_nacimiento }}</td>
        <td>{{ $obj->codigo_nua_cua }}</td>
        <td>{{ $obj->ci }}</td>
        <td>{{ $obj->ext }}</td>
        <td>{{ $obj->primer_nombre }}</td>
        <td>{{ $obj->segundo_nombre }}</td>
        <td>{{ $obj->apellido_paterno }}</td>
        <td>{{ $obj->apellido_materno }}</td>
        <td>{{ $obj->apellido_de_casado }}</td>
        <td>{{ $obj->fecha_nac }}</td>
        <td>{{ $obj->affiliate_id }}</td>
        <td>{{ $obj->ciudad}}</td>
    </tr>
    @endforeach
</table>
@endsection