<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tbody><tr>
<td align="center" valign="top" style="padding: 20px 0 20px 0">
<table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border: 1px solid #E0E0E0">
<tbody><tr>
<td valign="top"><a href="{{$gs->site}}" target="_blank" rel="noreferrer"><img src="{{asset('assets/images/'.$gs->logo)}}" alt="Partzdeal" style="margin-bottom: 10px" border="0"></a></td>
</tr>
<tr>
<td valign="top">
<h1 style="font-size: 22px; font-weight: normal; line-height: 22px; margin: 0 0 11px 0">Hello, {{$order->customer_name}}</h1>
<p style="font-size: 12px; line-height: 16px; margin: 0 0 10px 0">
Thank you for your order from {{$gs->site}}.
Once your package ships we will send an email with a link to track your order.
If you have any questions about your order please contact us at <a href="mailto:{{$gs->email}}" style="color: #1E7EC8" rel="noreferrer">{{$gs->site}}</a> or call us at <span class="v1nobr">{{$gs->phone}}</span>.
</p>
<p style="font-size: 12px; line-height: 16px; margin: 0">Your order confirmation is below. Thank you again for your business.</p>
</td>
</tr>
<tr>
<td>
<h2 style="font-size: 18px; font-weight: normal; margin: 0">Your Order #{{$order->order_number}} <small>(placed on {{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y H:i A')}})</small></h2>
</td>
</tr>
<tr>
<td>
<table cellspacing="0" cellpadding="0" border="0" width="650">
<thead>
<tr>
<th align="left" width="325" bgcolor="#EAEAEA" style="font-size: 13px; padding: 5px 9px 6px 9px; line-height: 1em">Billing Information:</th>
<th width="10"></th>
<th align="left" width="325" bgcolor="#EAEAEA" style="font-size: 13px; padding: 5px 9px 6px 9px; line-height: 1em">Payment Method:</th>
</tr>
</thead>
<tbody>
<tr>
<td valign="top" style="font-size: 12px; padding: 7px 9px 9px 9px; border-left: 1px solid #EAEAEA; border-bottom: 1px solid #EAEAEA; border-right: 1px solid #EAEAEA">
{{$order->customer_name}}<br>

{{$order->customer_address}}<br>
{{$order->customer_city}},  {{$order->customer_state}}, {{$order->customer_zip}}<br>
{{$order->customer_country}}<br>
T: {{$order->customer_phone}}


</td>
<td>&nbsp;</td>
<td valign="top" style="font-size: 12px; padding: 7px 9px 9px 9px; border-left: 1px solid #EAEAEA; border-bottom: 1px solid #EAEAEA; border-right: 1px solid #EAEAEA">
<p><strong>{{$order->method}}</strong></p>

<table>
<tbody>
<tr>
<th><strong>Payer Email:</strong></th>
</tr>
<tr>
<td>{{$order->customer_email}}</td>
</tr>
</tbody>
</table>


</td>
</tr>
</tbody>
</table>
<br>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
<thead>
<tr>
<th align="left" width="325" bgcolor="#EAEAEA" style="font-size: 13px; padding: 5px 9px 6px 9px; line-height: 1em">Shipping Information:</th>
<th width="10"></th>
<th align="left" width="325" bgcolor="#EAEAEA" style="font-size: 13px; padding: 5px 9px 6px 9px; line-height: 1em">Shipping Method:</th>
</tr>
</thead>
<tbody>
<tr>
<td valign="top" style="font-size: 12px; padding: 7px 9px 9px 9px; border-left: 1px solid #EAEAEA; border-bottom: 1px solid #EAEAEA; border-right: 1px solid #EAEAEA">
@if(empty($order->shipping_address))
{{$order->customer_name}}<br>

{{$order->customer_address}}<br>
{{$order->customer_city}},  {{$order->customer_state}}, {{$order->customer_zip}}<br>
{{$order->customer_country}}<br>
T: {{$order->customer_phone}}
@else
{{$order->customer_name}}<br>

{{$order->shipping_address}}<br>
{{$order->shipping_city}},  {{$order->shipping_state}}, {{$order->shipping_zip}}<br>
{{$order->shipping_country}}<br>
T: {{$order->customer_phone}}
@endif

&nbsp;
</td>
<td>&nbsp;</td>
<td valign="top" style="font-size: 12px; padding: 7px 9px 9px 9px; border-left: 1px solid #EAEAEA; border-bottom: 1px solid #EAEAEA; border-right: 1px solid #EAEAEA">
{{$order->shipping_method}}
&nbsp;
</td>
</tr>
</tbody>
</table>
<br>

<table cellspacing="0" cellpadding="0" border="0" width="650" style="border: 1px solid #EAEAEA">
<thead>
<tr>
<th align="left" bgcolor="#EAEAEA" style="font-size: 13px; padding: 3px 9px">Item</th>
<th align="left" bgcolor="#EAEAEA" style="font-size: 13px; padding: 3px 9px">Sku</th>
<th align="center" bgcolor="#EAEAEA" style="font-size: 13px; padding: 3px 9px">Qty</th>
<th align="right" bgcolor="#EAEAEA" style="font-size: 13px; padding: 3px 9px">Subtotal</th>
</tr>
</thead>                        

<tbody bgcolor="#F6F6F6">
@foreach($cart->items as $key => $product)
<tr>
<td align="left" valign="top" style="font-size: 11px; padding: 3px 9px; border-bottom: 1px dotted #CCCCCC">
<strong style="font-size: 11px">{{ $product['item']['name']}}</strong>
</td>
<td align="left" valign="top" style="font-size: 11px; padding: 3px 9px; border-bottom: 1px dotted #CCCCCC">{{ $product['item']['sku'] }}</td>
<td align="center" valign="top" style="font-size: 11px; padding: 3px 9px; border-bottom: 1px dotted #CCCCCC">{{$product['qty']}}</td>
<td align="right" valign="top" style="font-size: 11px; padding: 3px 9px; border-bottom: 1px dotted #CCCCCC">
<span class="v1price">{{$order->currency_sign}}{{ round($product['price'] * $order->currency_value , 2) }}</span></td>
</tr>
@endforeach
</tbody>
<tbody>
    @php
    $subtotal = $order->pay_amount - $order->shipping_cost;
    @endphp
<tr class="v1subtotal">
<td colspan="3" align="right" style="padding: 3px 9px">
Subtotal</td>
<td align="right" style="padding: 3px 9px">
<span class="v1price">{{$order->currency_sign}}{{ round($subtotal * $order->currency_value , 2) }}</span></td>
</tr>
<tr class="v1shipping">
<td colspan="3" align="right" style="padding: 3px 9px">
Shipping &amp; Handling                    </td>
<td align="right" style="padding: 3px 9px">
<span class="v1price">{{$order->currency_sign}}{{ round($order->shipping_cost * $order->currency_value , 2) }}</span></td>
</tr>
<tr class="v1grand_total">
<td colspan="3" align="right" style="padding: 3px 9px">
<strong>Grand Total</strong>
</td>
<td align="right" style="padding: 3px 9px">
<strong><span class="v1price">{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}</span></strong>
</td>
</tr>
</tbody>
</table>

<p style="font-size: 12px; margin: 0 10px 10px 0"></p>
</td>
</tr>
<tr>
<td bgcolor="#EAEAEA" align="center" style="background: #EAEAEA; text-align: center"><center><p style="font-size: 12px; margin: 0">Thank you again, <strong>partzdeal.com</strong></p></center></td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>