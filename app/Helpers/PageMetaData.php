<?php

namespace App\Helpers;

use App\Models\BlogPost;
use App\Models\Website_meta_description;
use App\Models\WebsiteMetaTitle;
use Illuminate\Support\Str;

class PageMetaData
{
    const DEFAULT_SUFFIX = "Insightblog";
    const DEFAULT_KEYWORDS = "Read, Research, Learn stuffs, Explore Services.";

    public static function getDefaultSuffix()
    {
        return self::DEFAULT_SUFFIX;
    }

    public static function getDefaultKeywords()
    {
        return self::DEFAULT_KEYWORDS;
    }

    public static function createMetaData($title, $description, $ogUrl, $ogImage = null)
    {
        $meta = new MetaData();
        $metaTitle = WebsiteMetaTitle::first();
        $customMetaData = Website_meta_description::first();

        $title = $title ?? ($metaTitle ? $metaTitle->meta_title : self::getDefaultSuffix());
        $description = $description ?? ($customMetaData ? $customMetaData->description : self::getDefaultKeywords());

        return $meta
            ->setAttribute("title", $title)
            ->setAttribute("description", $description)
            ->setAttribute("keywords", self::getDefaultKeywords())
            ->setAttribute("og_url", $ogUrl)
            ->setAttribute("og_image", $ogImage ?? asset('web/images/default-image.png'));
    }

    public static function welcome()
    {
        // $meta = new MetaData();
        $metaTitle = WebsiteMetaTitle::first();
        $customMetaData = Website_meta_description::first();

        $title = $title ?? ($metaTitle ? $metaTitle->meta_title : self::getDefaultSuffix());
        $description = $description ?? ($customMetaData ? $customMetaData->description : self::getDefaultKeywords());

        return self::createMetaData(
            'Welcome to ' .  $title,
            'Discover ' . $title .' - Your Premier Destination for Cutting-Edge Information and Tech Solutions. Explore Our Website Today!',
            'https://blog.swiftlysend.online/'
        );
    }

    public static function getPostMetaData(BlogPost $post)
    {
        $title = $post->title;
        $description = $post->meta_description ?? Str::limit($post->body, 150);
        $ogUrl = route('post.details', $post->slug);
        $ogImage = $post->cover_image ? asset('storage/blog/images/' . $post->cover_image) : asset('web/images/default-image.png');

        return self::createMetaData($title, $description, $ogUrl, $ogImage);
    }

    
}
