<script lang="ts">
    import TenantLayout from "@/Layouts/TenantLayout.svelte";

    const { patients } = $props<{ patients: any }>();
    console.log(patients);
</script>

<svelte:head>
    <title>Patients | Parsec Health</title>
</svelte:head>

<TenantLayout>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-semibold mb-4">Patients</h2>
    </div>
</TenantLayout>
