<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->mediumText('api_key');
            $table->integer('login_mandatory')->comment('0=No, 1=Yes');
            $table->integer('maintenance')->comment('0=No, 1=Yes');
            $table->integer('image_slider_type')->comment('0=Movie, 1=Web Series, 2=Custom, 3=Disable');
            $table->integer('movie_image_slider_max_visible')->default(5);
            $table->integer('webseries_image_slider_max_visible')->default(5);
            $table->text('onesignal_api_key');
            $table->text('onesignal_appid');
            $table->integer('ad_type')->default(0)->comment('0=No Ads, 1 =AdMob, 2=Startapp, 3=Facebook');
            $table->text('Admob_Publisher_ID');
            $table->text('Admob_APP_ID');
            $table->text('adMob_Native');
            $table->text('adMob_Banner');
            $table->text('adMob_Interstitial');
            $table->text('StartApp_App_ID');
            $table->text('facebook_app_id');
            $table->text('facebook_banner_ads_placement_id');
            $table->text('facebook_interstitial_ads_placement_id');
            $table->text('Latest_APK_Version_Name');
            $table->text('Latest_APK_Version_Code');
            $table->text('APK_File_URL');
            $table->text('Whats_new_on_latest_APK');
            $table->integer('Update_Skipable')->default(0)->comment('0=No, 1=Yes');
            $table->integer('Update_Type')->default(0)->comment('0=In App, 1 = External Brawser');
            $table->text('Contact_Email');
            $table->text('SMTP_Host');
            $table->text('SMTP_Username');
            $table->text('SMTP_Password');
            $table->text('SMTP_Port');
            $table->text('Dashboard_Version');
            $table->integer('shuffle_contents')->default(0)->comment('0=No, 1=Yes');
            $table->integer('Home_Rand_Max_Movie_Show')->default(0);
            $table->integer('Home_Rand_Max_Series_Show')->default(0);
            $table->integer('Home_Recent_Max_Movie_Show')->default(0);
            $table->integer('Home_Recent_Max_Series_Show')->default(0);
            $table->integer('Show_Message')->default(0)->comment('0=No, 1=Yes');
            $table->text('Message_Title');
            $table->text('Message');
            $table->integer('all_live_tv_type')->default(0)->comment('0=Default, 1=Free, 2=Paid');
            $table->integer('all_movies_type')->default(0)->comment('0=Default, 1=Free, 2=Paid');
            $table->integer('all_series_type')->default(0)->comment('0=Default, 1=Free, 2=Paid');
            $table->integer('LiveTV_Visiable_in_Home')->default(1)->comment('0=No, 1=Yes');
            $table->longText('TermsAndConditions');
            $table->longText('PrivecyPolicy');
            $table->text('tmdb_language');
            $table->text('admin_panel_language');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config');
    }
}
