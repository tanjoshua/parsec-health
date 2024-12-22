<script>
    // Remove linting warning coming from HandleInertiaRequests
    // https://inertiajs.com/shared-data
    /* svelte-ignore unused-export-let */
    export let errors = {};
    /* svelte-ignore unused-export-let */
    export let auth = {};
    import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import * as Tabs from "@/components/ui/tabs/index.ts";
</script>

<svelte:head>
    <title>Dashboard | Parsec Health</title>
</svelte:head>

<BreezeAuthenticatedLayout>
    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-semibold mb-4">Patient Visits</h2>
                <Tabs.Root value="account">
                    <Tabs.List class="grid w-full grid-cols-2">
                        <Tabs.Trigger value="active">Active</Tabs.Trigger>
                        <Tabs.Trigger value="completed">Completed</Tabs.Trigger>
                    </Tabs.List>
                    <Tabs.Content value="active">
                        Make changes to your account here.
                    </Tabs.Content>
                    <Tabs.Content value="completed"
                        >Change your password here.</Tabs.Content
                    >
                </Tabs.Root>
            </div>
            <div></div>
        </div>
    </div>
</BreezeAuthenticatedLayout>
