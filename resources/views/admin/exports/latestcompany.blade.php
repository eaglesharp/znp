<table>
    <thead>
    <tr>
       
        <th>Latest Company</th>
        <th>Latest Company id</th>
        
       
        
       
    </tr>
    </thead>
    <tbody>
    @foreach($companies as $item)
   
    

        <tr>
           
            <td>{{ $item->name ?? '' }}</td>
            <td>{{ $item->id ?? '' }}</td>
          
           
        </tr>
      
    @endforeach
    </tbody>
</table>