<h3>{{ $user->name }} 様</h3>
<p>ご購入ありがとうございました。</p>

<p>購入された商品内容</p>
@foreach ($items as $item)
    <ul>
        <li>商品名：{{ $item['name'] }}</li>
        <li>商品金額：{{ number_format($item['price']) }}円（税込）</li>
        <li>商品数：{{ $item['quantity'] }}個</li>
        <li>合計金額：{{ number_format($item['price'] * $item['quantity']) }}円（税込）</li>
    </ul>
@endforeach
