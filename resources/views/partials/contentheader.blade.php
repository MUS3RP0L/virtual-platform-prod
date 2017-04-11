<section class="content-header">

  {{-- @foreach (Auth::user()->roles as $role)
      <li>{{$role->module}}</li>
  @endforeach --}}
  
    <h1>
        @yield('contentheader_title')
    </h1>
</section>
