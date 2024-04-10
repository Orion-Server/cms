@extends('layouts.app')

@section('title', __('Safety'))

@section('content')
    <x-container class="mt-10 flex flex-col gap-8">
        <div class="flex flex-col justify-center items-center gap-2">
            <span class="text-3xl font-bold text-slate-800 dark:text-slate-200 underline underline-offset-4 decoration-emerald-500">
                {{ __('Safety Tips') }}
            </span>
            <span class="text-sm dark:text-slate-400 text-slate-600">
                {{ __('These are the top 7 tips for how to navigate the internet safely and securely!') }}
            </span>

            <div class="mt-8 border-t-4 dark:border-slate-700 flex flex-col w-full">
                <div class="py-8 flex border-b-4 border-dotted dark:border-slate-800">
                    <img width="210" src="https://imgur.com/2e70Iz3.png" alt="personal_info" />
                    <div class="flex flex-col gap-4 pl-4 h-full">
                        <span class="text-xl font-extrabold text-slate-700 dark:text-slate-100 uppercase">
                            <b class="text-green-500">1.</b> {{ __('Protect your personal info') }}
                        </span>
                        <span class="text-sm dark:text-slate-400 text-slate-600">
                            {{ __("You never know who you're truly speaking to online, so never share your personal information! Giving away your personal info - real name, address, phone numbers, photos or school - could lead to you being scammed, bullied or put in serious danger.") }}
                        </span>
                    </div>
                </div>
                <div class="py-8 flex border-b-4 border-dotted dark:border-slate-800">
                    <div class="flex flex-col gap-4 pl-4 h-full">
                        <span class="text-xl font-extrabold text-slate-700 dark:text-slate-100 uppercase">
                            <b class="text-green-500">2.</b> {{ __('Protect your privacy') }}
                        </span>
                        <span class="text-sm dark:text-slate-400 text-slate-600">
                            {{ __("Never share your any of your personal details. This includes Facebook, Instagram, etc. You never know who might get their hands on it!") }}
                        </span>
                    </div>
                    <img width="210" src="https://imgur.com/epPGwWb.png" alt="privacy_safety" />
                </div>
                <div class="py-8 flex border-b-4 border-dotted dark:border-slate-800">
                    <img width="190" src="https://imgur.com/mjRlc1T.png" alt="pressure_safety" />
                    <div class="flex flex-col gap-4 pl-4 h-full">
                        <span class="text-xl font-extrabold text-slate-700 dark:text-slate-100 uppercase">
                            <b class="text-green-500">3.</b> {{ __("Don't Give In To Peer Pressure") }}
                        </span>
                        <span class="text-sm dark:text-slate-400 text-slate-600">
                            {{ __("Just because everyone else seems to be doing it, doesn't mean you have to. If you are not comfortable with something, don't do it!") }}
                        </span>
                    </div>
                </div>
                <div class="py-8 flex border-b-4 border-dotted dark:border-slate-800">
                    <div class="flex flex-col gap-4 pl-4 h-full">
                        <span class="text-xl font-extrabold text-slate-700 dark:text-slate-100 uppercase">
                            <b class="text-green-500">4.</b> {{ __("Keep Your Pals In Pixels") }}
                        </span>
                        <span class="text-sm dark:text-slate-400 text-slate-600">
                            {{ __("Do not meet up with someone you only know from the internet! People aren't always who they claim to be. If a Habbo asks you to meet with them in real life say \"No, thanks!\" click 'Ignore' on them and tell your parents or another trusted adult.") }}
                        </span>
                    </div>
                    <img width="200" src="https://imgur.com/m8lDyZz.png" alt="pixels_friends" />
                </div>
                <div class="py-8 flex border-b-4 border-dotted dark:border-slate-800">
                    <img width="199" src="https://imgur.com/EWpJi1O.png" alt="speak_up" />
                    <div class="flex flex-col gap-4 pl-4 h-full">
                        <span class="text-xl font-extrabold text-slate-700 dark:text-slate-100 uppercase">
                            <b class="text-green-500">5.</b> {{ __("Don't Be Scared To Speak Up") }}
                        </span>
                        <span class="text-sm dark:text-slate-400 text-slate-600">
                            {{ __("If someone is making you feel uncomfortable, threatening you, or pressuring you to do something you don't want to, put them on ignore, and report them immediately to our moderation team.") }}
                        </span>
                    </div>
                </div>
                <div class="py-8 flex border-b-4 border-dotted dark:border-slate-800">
                    <div class="flex flex-col gap-4 pl-4 h-full">
                        <span class="text-xl font-extrabold text-slate-700 dark:text-slate-100 uppercase">
                            <b class="text-green-500">6.</b> {{ __("Ban The Cam") }}
                        </span>
                        <span class="text-sm dark:text-slate-400 text-slate-600">
                            {{ __("You have no control over your personal photos, videos + webcam images after you share them on the internet. Once an image is posted, it can never be removed, will be viewable by anyone and could be used to bully or blackmail you. Before you share a pic or video, ask yourself; are you comfortable with people you don't know viewing it?") }}
                        </span>
                    </div>
                    <img width="198" src="https://imgur.com/OovoYO9.png" alt="ban_cam" />
                </div>
            </div>
                <div class="py-8 flex">
                    <img width="201" src="https://imgur.com/Xm7jQcy.png" alt="stick_real_habbo" />
                    <div class="flex flex-col gap-4 pl-4 h-full">
                        <span class="text-xl font-extrabold text-slate-700 dark:text-slate-100 uppercase">
                            <b class="text-green-500">7.</b> {{ __("Stick To The Real Habbo!") }}
                        </span>
                        <span class="text-sm dark:text-slate-400 text-slate-600">
                            {{ __("Websites that offer free prizes, credits, furni, or \"staff rights\" are ALL scams designed to steal your password. Never give them your login details or download files from these websites. They could be keyloggers or viruses!") }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
@endsection
