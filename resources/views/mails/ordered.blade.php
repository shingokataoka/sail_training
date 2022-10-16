<h2>{{ $item['ownerName'] }} 様の商品が購入されました。</h2>

<h3 style="padding-top: 16px">商品情報</h3>
 <ul>
    <li>商品名：{{ $item['name'] }}</li>
    <li>商品金額：{{ number_format($item['price']) }}円（税込）</li>
    <li>商品数：{{ $item['quantity'] }}</li>
    <li>合計金額：{{ number_format($item['price'] * $item['quantity']) }}円（税込）</li>
 </ul>

<h3 style="padding-top: 16px">購入者情報</h3>
<p>{{ $user->name }} 様</p>

