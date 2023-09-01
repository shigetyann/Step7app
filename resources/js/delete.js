function confirm_delete(e){
    if(!window.confirm('本当に削除しますか？')){
        window.alert('キャンセルされました');
        return false;
    }
    document.delete_form.submit();
};
