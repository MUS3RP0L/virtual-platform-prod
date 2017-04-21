@extends('globalprint.print')
@section('title2')

@endsection
@section('content')
      <div id="project">
        <table>
           <tr>
              <th class="grand"><h4>NRO</h4></th>
              <th class="grand"><h4>GRADO</h4></th>
              <th class="grand"><h4>RENTA</h4></th>
              <th class="grand"><h4>RENTA MENOR</h4></th>
              <th class="grand"><h4>RENTA MAYOR</h4></th>
              <th class="grand"><h4>PROMEDIO</h4></th>
           </tr>
           <?php $i=1;?>
            @foreach($average_list as $item)
            <tr>
              <td ><h4>{!! $i !!}</h4></td>
              <td ><h4>{!! $item->degree !!}</h4></td>
              <td ><h4>{!! $item->type !!}</h4></td>
              <td ><h4>{!! $item->rmin !!}</h4></td>
              <td ><h4>{!! $item->rmax !!}</h4></td>
              <td ><h4>{!! $item->average !!}</h4></td>
            </tr>
            <?php $i++;?>
            @endforeach
        </table>
    </div>


@endsection
