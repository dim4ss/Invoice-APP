

<h1>Data Client</h1>

<a href="{{ route('clients.create') }}">Tambah Client</a>

<ul>
@foreach ($clients as $client)
    <li>{{ $client->name }} - {{ $client->email }}</li>
@endforeach
</ul>