                    <tbody>
                        @foreach($data as $key => $value)
                        <tr>
                        @php    
                            $timeDifference = \Carbon\Carbon::parse($value->check_out)->diffInHours(\Carbon\Carbon::parse($value->check_in));
                            $hours= $timeDifference; 
                     @endphp

                          
                            <td>{{ \Carbon\Carbon::parse($value->date)->format('Y-m-d') }}</td>
                            <td>{{$value->user->name}}<br><span class="badge badge-info">{{$value->user->user_id}}</span></td>
                            <td>{{$value->check_in}}</td>
                            <td>{{$value->check_out}}</td>
                            <td>{{$hours}}</td>
                            <td>@if($hours<=0)
                            Absent
                            @else
                            Present
                            @endif
                                
                            </td>
                            <td>
                                <a href="#" class="pr-2"><i class="nc-icon nc-tag-content"></i></a>
                                <a href="#"><i class="nc-icon nc-basket"></i></a>
                            </td>
                        </tr>
@endforeach
                    </tbody>