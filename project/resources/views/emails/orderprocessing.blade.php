<h4>New order has been received. However the customer has not processed the payment</h4>
<p>As per our records, customer contact details are as follows:</p>
<table border="1"><tbody>
<tr><td style="background: #cccccc; text-align: left">
<h6 style="font-size: 12px; font-weight: 700; margin-bottom: 0px; margin-top: 5px; text-transform: uppercase; float: left; width: 140px">Name:</h6></td>
<td><p>{{$order->customer_name}}</p></td></tr><tr><td style="background: #cccccc; text-align: left">
<h6 style="font-size: 12px; font-weight: 700; margin-bottom: 0px; margin-top: 5px; text-transform: uppercase; float: left; width: 140px">Email:</h6></td>
<td><p>{{$order->customer_email}}</p></td></tr><tr><td style="background: #cccccc; text-align: left">
<h6 style="font-size: 12px; font-weight: 700; margin-bottom: 0px; margin-top: 5px; text-transform: uppercase; float: left; width: 140px">Contact Number:</h6></td>
<td><p>{{$order->customer_phone}}</p></td></tr>
<tr><td style="background: #cccccc; text-align: left">
<h6 style="font-size: 12px; font-weight: 700; margin-bottom: 0px; margin-top: 5px; text-transform: uppercase; float: left; width: 140px">Country:</h6></td>
<td><p>{{$order->customer_country}}</p></td></tr><tr><td style="background: #cccccc; text-align: left"><h6 style="font-size: 12px; font-weight: 700; margin-bottom: 0px; margin-top: 5px; text-transform: uppercase; float: left; width: 140px">Region:</h6></td>
<td><p>{{$order->customer_state}}</p></td></tr><tr><td style="background: #cccccc; text-align: left"><h6 style="font-size: 12px; font-weight: 700; margin-bottom: 0px; margin-top: 5px; text-transform: uppercase; float: left; width: 140px">City:</h6></td>
<td><p>{{$order->customer_city}}</p></td></tr><tr><td style="background: #cccccc; text-align: left"><h6 style="font-size: 12px; font-weight: 700; margin-bottom: 0px; margin-top: 5px; text-transform: uppercase; float: left; width: 140px">Postal Code:</h6></td>
<td><p>{{$order->customer_state}}</p></td></tr>
<tr><td style="background: #cccccc; text-align: left">
<h6 style="font-size: 12px; font-weight: 700; margin-bottom: 0px; margin-top: 5px; text-transform: uppercase; float: left; width: 140px">Total Amount:</h6></td>
<td><p>{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}</p></td></tr>
<tr><td style="background: #cccccc; text-align: left">
<h6 style="font-size: 12px; font-weight: 700; margin-bottom: 0px; margin-top: 5px; text-transform: uppercase; float: left; width: 140px">Store:</h6></td>
<td><p>{{$store_code}}</p></td></tr>
</tbody></table>