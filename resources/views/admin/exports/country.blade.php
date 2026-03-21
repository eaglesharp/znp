<table>
    <thead>
    <tr>
        <th>Country</th>
        <th>Country Code</th>
       
       
        
       
    </tr>
    </thead>
    <tbody>
    @foreach($country as $item)
   
   
        <tr>
            <td>{{ $item->country ?? '' }}</td>
            <td>{{ $item->id ?? '' }}</td>
            
       
           
          
           
        </tr>
      
    @endforeach
    </tbody>
</table>