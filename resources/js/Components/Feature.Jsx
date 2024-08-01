import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, userPage } from '@inertiajs/react';


export default function Feature({feature, answer, children}){
    const { auth } = userPage().props;

    const availableCredits = auth.user.availableCredits;
}