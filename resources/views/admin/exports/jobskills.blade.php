<table>
    <thead>
    <tr>
        <th>Job Skills</th>
        <th>Job Skills Code</th>
       
       
        
       
    </tr>
    </thead>
    <tbody>
    @foreach($jobskills as $item)
   
   
        <tr>
            <td>{{ $item->job_skill ?? '' }}</td>
            <td>{{ $item->id ?? '' }}</td>
            
       
           
          
           
        </tr>
      
    @endforeach
    </tbody>
</table>