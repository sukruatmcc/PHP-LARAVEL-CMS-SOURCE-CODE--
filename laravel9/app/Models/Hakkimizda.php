<?php

       namespace App\Models;
       
       use Illuminate\Database\Eloquent\Factories\HasFactory;
       use Illuminate\Database\Eloquent\Model;
       
       class Hakkimizda extends Model
       {   
           use HasFactory;
           protected $table="hakkimizda";
           protected $fillable=["id","başlık","selflink","kategori","resim","metin","tablo","anahtar","description","durum","sıra_no","created_at","uptadet_at"];
           
       }