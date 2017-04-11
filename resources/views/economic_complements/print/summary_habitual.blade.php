@extends('globalprint.print')
@section('title2')
@endsection
@section('content')
      <div id="project">
        <table>
           <tr>
               <th class="grand"><h4>REG</h4></th>
               <th class="grand"><h4>RE</h4></th>
               <th class="grand"><h4>GR</h4></th>
               <th class="grand"><h4>GR</h4></th>
               <th class="grand"><h4>SGR</h4></th>
               <th class="grand"><h4>IGR</h4></th>
               <th class="grand"><h4>DGR</h4></th>
               <th class="grand"><h4>CNL</h4></th>
               <th class="grand"><h4>CNL</h4></th>
               <th class="grand"><h4>TCL</h4></th>
               <th class="grand"><h4>MY</h4></th>
               <th class="grand"><h4>CAP</h4></th>
               <th class="grand"><h4>TTE</h4></th>
               <th class="grand"><h4>STE</h4></th>
               <th class="grand"><h4>CA</h4></th>
               <th class="grand"><h4>TCA</h4></th>
               <th class="grand"><h4>MA</h4></th>
               <th class="grand"><h4>CA</h4></th>
               <th class="grand"><h4>TA</h4></th>
               <th class="grand"><h4>SB</h4></th>
               <th class="grand"><h4>SSP</h4></th>
               <th class="grand"><h4>SMY</h4></th>
               <th class="grand"><h4>SF1</h4></th>
               <th class="grand"><h4>SF2</h4></th>
               <th class="grand"><h4>SG1</h4></th>
               <th class="grand"><h4>SG2</h4></th>
               <th class="grand"><h4>CBO</h4></th>
               <th class="grand"><h4>POL</h4></th>
               <th class="grand"><h4>SSA</h4></th>
               <th class="grand"><h4>SMA</h4></th>
               <th class="grand"><h4>S1A</h4></th>
               <th class="grand"><h4>S2A</h4></th>
               <th class="grand"><h4>S1A</h4></th>
               <th class="grand"><h4>S2A</h4></th>
               <th class="grand"><h4>CA</h4></th>
               <th class="grand"><h4>PA</h4></th>
               <th class="grand"><h4>STT</h4></th>
           </tr>
            @foreach($deparment_list as $department1 => $departments)
                <?php $j=1;?>
                @foreach($departments as $renta1 => $renta)
                    <tr>
                        @if($j==1)
                        <td rowspan="3"><h4>{!! $department1 !!}</h4></td>
                        @endif
                        <td><h4>{!! $renta1 !!}</h4></td>
                        <?php $tr=0;?>
                        @foreach($renta as $degree1 => $degree)
                            <td><h4>{!! $degree->total !!}</h4></td>
                            <?php $tr= $tr + $degree->total;?>
                        @endforeach
                        <td><h4>{!! $tr !!}</h4></td>
                        <?php $j++;?>
                    </tr>
                @endforeach            
            @endforeach
        </table>
    </div>
@endsection
