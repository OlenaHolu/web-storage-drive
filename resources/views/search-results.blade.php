 <h1>Resultados de Búsqueda</h1>
 <table>
     <tr>
         <th>Name</th>
         <th>Size</th>
         <th>Owner</th>
         <th>Created at</th>
         <th>Updated at</th>
     </tr>
     @forelse ($ficheros as $fichero)
         <tr>
             <td><a href="/download/{{ $fichero->id }}">{{ $fichero->name }}</a></td>
             <td>{{ $fichero->size() }}</td>
             <td>{{ $fichero->user->name }}</td>
             <td>{{ $fichero->created_at->toDateString() }}</td>
             <td>{{ $fichero->updated_at->toDateString() }}</td>
         </tr>
     @empty
         <tr>
             <td colspan="5">No se encontraron ficheros que coincidan con la búsqueda.</td>
         </tr>
     @endforelse
 </table>
