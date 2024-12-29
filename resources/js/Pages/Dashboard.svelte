<script lang="ts">
    import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import PatientVisits from "@/components/dashboard/PatientVisits.svelte";
    import type { Visit } from "@/types/visit";

    const { activeVisits } = $props<{
        activeVisits: Visit[];
    }>();

    // Add a reactive time value that updates every minute
    let now = $state(new Date());

    $effect(() => {
        const interval = setInterval(() => {
            now = new Date();
        }, 60000); // Update every minute

        return () => clearInterval(interval); // Cleanup on component destroy
    });
</script>

<svelte:head>
    <title>Dashboard | Parsec Health</title>
</svelte:head>

<BreezeAuthenticatedLayout>
    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <PatientVisits {activeVisits} {now} />
            <div></div>
        </div>
    </div>
</BreezeAuthenticatedLayout>
