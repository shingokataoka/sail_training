<?php

namespace App\Constants;

class Common
{
    const PRODUCT_ADD = '1';
    const PRODUCT_REDUCE = '2';
    const PRODUCT_CANCEL = '3';

    const SORT_RECOMMEND = '1';
    const SORT_HIGHER_PRICE = '2';
    const SORT_LOWER_PRICE = '3';
    const SORT_LATEST = '4';
    const SORT_OLDER = '5';

    const SORT_LIST = [
        'おすすめ順' => self::SORT_RECOMMEND,
        '価格の高い順' => self::SORT_HIGHER_PRICE,
        '価格の安い順' => self::SORT_LOWER_PRICE,
        '新しい順' => self::SORT_LATEST,
        '古い順' => self::SORT_OLDER,
        ];
}



