<?php

       namespace App\Models;
       
       use Illuminate\Database\Eloquent\Factories\HasFactory;
       use Illuminate\Database\Eloquent\Model;
       
       class Hizmetler extends Model
       {   
           use HasFactory;
           protected $table="hizmetler";
           protected $fillable=["id","başlık","selflink","kategori","resim","metin","tablo","anahtar","description","durum","sira_no","created_at","updated_at"];
           
       }