@extends('globalprint.print')

@section('formnumber')

@endsection

@section('content')

<div ><h1>{!! Auth::user()->getFullName() !!} </h1></div><br />
<div id="project">
        <table>
            <tr>
              <th class="grand">N°</th>
              <th class="grand">FECHA</th>
              <th class="grand">ACTIVIDAD</th>
              <th class="grand">USUARIO</th>
              <th class="grand">TIPO</th>

            </tr>
            <?php $i=1;?>
            @foreach($activities as $item)
            <tr>
                <td><center>{!! $i !!}</center></td>
                <td>{!! $item->created_at !!}</td>
                <td>{!! $item->message !!}</td>
                <td>{!! Auth::user()->username !!}</td>
                <td>{!! $item->activity_type_id !!}</td>
            </tr>
            <?php $i++;?>
            @endforeach
        </table>
</div>
@endsection
