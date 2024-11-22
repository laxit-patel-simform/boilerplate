import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { ButtonGroup, Button } from "@material-tailwind/react";

export default function Dashboard() {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            You're logged in!
                        </div>
                        <div className="flex flex-col gap-4">
                            <ButtonGroup variant="ghost">
                                <Button>React</Button>
                                <Button>Vue</Button>
                                <Button>Svelte</Button>
                            </ButtonGroup>
                            <ButtonGroup variant="outline">
                                <Button>React</Button>
                                <Button>Vue</Button>
                                <Button>Svelte</Button>
                            </ButtonGroup>
                            <ButtonGroup variant="solid">
                                <Button>React</Button>
                                <Button>Vue</Button>
                                <Button>Svelte</Button>
                            </ButtonGroup>
                            <ButtonGroup variant="gradient">
                                <Button>React</Button>
                                <Button>Vue</Button>
                                <Button>Svelte</Button>
                            </ButtonGroup>
                        </div>

                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
