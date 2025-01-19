<script lang="ts">
	import * as Table from "@/components/ui/table";
	import type { Customer } from "@/types/customer";
	import type { PaginatedResult } from "@/types/pagination";
	import PatientTableActions from "./patient-table-actions.svelte";
	import { useForm } from "@inertiajs/svelte";
	import SearchInput from "../ui/input/search-input.svelte";
	import PaginationBar from "../table/pagination-bar.svelte";

	let {
		customers,
		search,
		pageSize,
	}: {
		customers: PaginatedResult<Customer>;
		search: string;
		pageSize: string;
	} = $props();

	const form = useForm({
		search: search,
		pageSize: pageSize,
	});

	const onSubmit = () => {
		$form
			.transform((data) => ({
				search: data.search ? data.search : undefined,
				pageSize: data.pageSize == "10" ? undefined : data.pageSize,
				page: 1,
			}))
			.get("");
	};

	const onSearch = (e: SubmitEvent) => {
		e.preventDefault();
		onSubmit();
	};
</script>

<div class="mb-4 flex justify-between">
	<form onsubmit={onSearch}>
		<SearchInput
			name="search"
			type="search"
			placeholder="Search Patients"
			class=""
			bind:value={$form.search}
			onCancel={() => {
				$form.search = "";
				onSubmit();
			}}
		/>
	</form>
</div>

<div class="rounded-md border">
	<Table.Root>
		<Table.Header>
			<Table.Row>
				<Table.Head>Patient Number</Table.Head>
				<Table.Head>Name</Table.Head>
				<Table.Head>Date of Birth</Table.Head>
				<Table.Head></Table.Head>
			</Table.Row>
		</Table.Header>
		<Table.Body>
			{#each customers.data as customer (customer.id)}
				<Table.Row>
					<Table.Cell class="w-[200px]">
						{customer.tenant_customer_number
							.toString()
							.padStart(4, "0")}
					</Table.Cell>
					<Table.Cell class="font-medium">
						{customer.name}
					</Table.Cell>
					<Table.Cell>{customer.date_of_birth}</Table.Cell>
					<Table.Cell>
						<PatientTableActions id={customer.id.toString()} />
					</Table.Cell>
				</Table.Row>
			{:else}
				<Table.Row>
					<Table.Cell colspan={4} class="h-24 text-center">
						No results.
					</Table.Cell>
				</Table.Row>
			{/each}
		</Table.Body>
	</Table.Root>
</div>

<div class="mt-4">
	<PaginationBar
		pagination={customers}
		pageSize={$form.pageSize}
		onPageSizeChange={(value) => {
			$form.pageSize = value;
			onSubmit();
		}}
	/>
</div>
