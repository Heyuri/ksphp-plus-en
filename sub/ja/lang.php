<?php

$MSG = array(

    /* Service / access */
    'BBS_OUT_OF_SERVICE'      => 'This bulletin board is currently out of service.',
    'ACCESS_PROHIBITED'       => 'Access is prohibited.',

    /* Generic / IO errors */
    'FAILED_TO_READ_MESSAGE'  => 'メッセージ読み込みに失敗しました',
    'FAILED_TO_OPEN_LOG'      => '過去ログファイルがサイズ制限を超えています',
    'FAILED_TO_OUTPUT_LOG'    => '過去ログ出力に失敗しました',
    'OLDLOG_TOO_LARGE'        => '過去ログファイルがサイズ制限を超えています',
    'PARTICIPANT_FILE_ERROR'  => '参加者ファイル出力エラー',

    /* Posting / validation */
    'POSTING_SUSPENDED'       => 'この掲示板は現在投稿機能停止中です。',
    'ADMIN_ONLY_POSTING'      => '掲示板への投稿は管理者のみ許可されています。',
    'BAD_REFERER'             => '投稿画面のＵＲＬが <br>{REFCHECKURL}<br>以外からの投稿はできません。',
    'POST_TOO_WIDE'           => '投稿内容の桁数が大きすぎます。',
    'POST_TOO_MANY_LINES'     => '投稿内容の行数が大きすぎます。',
    'POST_TOO_LARGE'          => '投稿内容が大きすぎます。',
    'NAME_TOO_LONG'           => '投稿者欄の文字数が多すぎます。 ( {MAXNAMELENGTH} 文字まで)',
    'EMAIL_TOO_LONG'          => 'メール欄の文字数が多すぎます。 ( {MAXMAILLENGTH} 文字まで)',
    'TITLE_TOO_LONG'          => 'タイトル欄の文字が多すぎます。 ( {MAXTITLELENGTH} 文字まで)',
    'POST_TOO_FAST'           => '投稿間隔が短すぎます。もう一度やり直して下さい。',
    'NGWORD_FOUND'            => '投稿禁止語句が含まれています。',
    'SPAM_KUN'                => 'SPAM-KUN GTFO!!!',

    /* Caller / request */
    'INVALID_CALLER'          => '呼び出し元が不正です。',
    'NO_PARAMETERS'           => 'パラメータがありません。',
    'INVALID_PASSWORD'        => 'パスワードが違います。',

    /* Follow / search / reference */
    'MESSAGE_NOT_FOUND'       => '指定されたメッセージが見つかりません。',
    'REFERENCE_NOT_FOUND'     => '参照記事が見つかりません。',
    'REFERENCE_COLON'         => 'Reference:',
    'FOLLOW_UP_POST'          => 'フォロー投稿',
    'POST_SEARCH'             => '投稿検索',

    /* Completion / undo */
    'POST_COMPLETE'           => '書き込み完了',
    'DELETION_COMPLETE'       => '消去完了',
    'UNDO_POST_NOT_FOUND'     => '該当記事は見つかりませんでした。',
    'UNDO_NOT_PERMITTED'      => '該当記事の消去は許可されていません。',

    /* Main list footer messages */
    'POSTS_RANGE_NEWEST_TO_OLDEST' => '以上は、現在登録されている新着順{BINDEX}番目から{EINDEX}番目までの記事です。 ',
    'NO_UNREAD_MESSAGES'           => '未読メッセージはありません。',
    'NO_POSTS_BELOW'               => 'これ以下の記事はありません。',

    /* New post page */
    'NEW_POST' => '新規投稿',

    /* Labels / tags inserted into messages */
    'HACKER_TAG'       => '(hacker)',
    'FRAUDSTER_TAG'    => '(fraudster)',
    'SELF_REPLY_TAG'   => '(self-reply)',

	/* HTML titles */
	'TITLE_FOLLOWUP'         => 'フォロー投稿(返信)',
	'TITLE_SEARCH_BY_USER'   => '投稿者検索',
	'TITLE_THREAD_VIEW'      => 'スレッド表示',
	'TITLE_TREE_VIEW'        => 'ツリー表示',
	'TITLE_DELETE_POST'      => '投稿を消す',

);
