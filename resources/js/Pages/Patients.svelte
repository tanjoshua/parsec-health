<script lang="ts">
	import PatientTable from "@/components/patients/patient-table.svelte";
	import TenantLayout from "@/Layouts/TenantLayout.svelte";
	import type { PaginatedResult } from "@/types/pagination";
	import type { Patient } from "@/types/patient";

	let {
		patients,
		search,
		pageSize,
	}: {
		patients: PaginatedResult<Patient>;
		search: string;
		pageSize: number;
	} = $props();
</script>

<svelte:head>
	<title>Patients | Parsec Health</title>
</svelte:head>

<TenantLayout>
	<div class="container mx-auto p-4 space-y-8">
		<div>
			<h2 class="text-2xl font-bold">Patients</h2>
		</div>
		<div>
			<PatientTable {patients} {search} pageSize={pageSize.toString()} />
		</div>
	</div>
</TenantLayout>
