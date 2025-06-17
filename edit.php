<?php
if(isset($_POST['text']) && isset($_POST['filename'])) {
    $text = $_POST['text'];

    // استفاده از تابع realpath برای تبدیل مسیر نسبی فایل به مسیر کامل آن.
    $filename = realpath('./') . '/' . basename($_POST['filename']) . '.json';

        // استفاده از تابع file_put_contents برای ساده کردن کد
        if(file_put_contents($filename, $text) !== false) {
            echo "با موفقیت ویرایش شد";
        } else {
            echo "خطایی رخ داد";
        }

    // استفاده از بلاک finally برای بستن فایل در هر صورتی (حتی در صورت بروز خطا)
    try {
        if(isset($file)) {
            fclose($file);
        }
    } catch (Exception $e) {
        // نادیده گرفتن خطای بستن فایل
    }
}
?>