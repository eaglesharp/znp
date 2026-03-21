<table>
    <thead>
    <tr>
       
        <th>Career Level</th>
        <th>Career Level Code</th>
        
       
        
       
    </tr>
    </thead>
    <tbody>
    @foreach($career as $item)
   
    

        <tr>
           
            <td>{{ $item->career_level ?? '' }}</td>
            <td>{{ $item->career_level_id ?? '' }}</td>
          
           
        </tr>
      
    @endforeach
    </tbody>
</table>