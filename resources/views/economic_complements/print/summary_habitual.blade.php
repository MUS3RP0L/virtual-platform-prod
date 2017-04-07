@extends('globalprint.print')
@section('title2')
@endsection
@section('content')
      <div id="project">
        <table>
           <tr>
               <th class="grand"><h4>REGIONAL</h4></th>
               <th class="grand"><h4>TIPO</h4></th>
               <th class="grand"><h4>GRAL</h4></th>
               <th class="grand"><h4>GRAL</h4></th>
               <th class="grand"><h4>SBCMTE GRAL</h4></th>
               <th class="grand"><h4>INSP GRAL</h4></th>
               <th class="grand"><h4>DIR GRAL</h4></th>
               <th class="grand"><h4>CNL</h4></th>
               <th class="grand"><h4>CNL</h4></th>
               <th class="grand"><h4>TCNL</h4></th>
               <th class="grand"><h4>MY</h4></th>
               <th class="grand"><h4>CAP</h4></th>
               <th class="grand"><h4>TTE</h4></th>
               <th class="grand"><h4>SUBTTE</h4></th>
               <th class="grand"><h4>CNL ADM</h4></th>
               <th class="grand"><h4>TCNL ADM</h4></th>
               <th class="grand"><h4>MY ADM</h4></th>
               <th class="grand"><h4>CAP ADM</h4></th>
               <th class="grand"><h4>TTE ADM</h4></th>
               <th class="grand"><h4>SBTTE ADM</h4></th>
               <th class="grand"><h4>SOF SUP</h4></th>
               <th class="grand"><h4>SOF MY</h4></th>
               <th class="grand"><h4>SOF 1RO</h4></th>
               <th class="grand"><h4>SOF 2DO</h4></th>
               <th class="grand"><h4>SGTO 1RO</h4></th>
               <th class="grand"><h4>SGTO 2DO</h4></th>
               <th class="grand"><h4>CBO</h4></th>
               <th class="grand"><h4>POL</h4></th>
               <th class="grand"><h4>SOF SUP ADM</h4></th>
               <th class="grand"><h4>SOF MY ADM</h4></th>
               <th class="grand"><h4>SOF 1RO ADM</h4></th>
               <th class="grand"><h4>SOF 2DO ADM</h4></th>
               <th class="grand"><h4>SGTO 1RO ADM</h4></th>
               <th class="grand"><h4>SGTO 2DO ADM</h4></th>
               <th class="grand"><h4>CBO ADM</h4></th>
               <th class="grand"><h4>POL ADM</h4></th>
           </tr>
           <?php $i=1;?>
            @foreach($deparment_list as $item)
            <tr>
                <td ><h4>{!! $i !!}</h4></td>

            </tr>
            <?php $i++;?>
            @endforeach
        </table>
    </div>
@endsection
