<table>

    <thead>

    <tr>
        
         <th>id</th>

        <th>Specilation</th>

        <th>course id </th>

       

        

       

        

       

    </tr>

    </thead>

    <tbody>

    @foreach($specs as $item)

   

    



        <tr>

            <td>{{ $item->id ?? '' }}</td>

            <td>{{ $item->specs ?? '' }}</td>

            <td>{{ $item->course_id ?? '' }}</td>

           

          

           

        </tr>

      

    @endforeach

    </tbody>

</table>