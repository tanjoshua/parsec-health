<script lang="ts">
	import { type ColumnDef, getCoreRowModel } from "@tanstack/table-core";
	import {
		createSvelteTable,
		FlexRender,
		renderComponent,
	} from "@/components/ui/data-table";
	import * as Table from "@/components/ui/table";
	import * as Select from "@/components/ui/select";
	import { Button } from "@/components/ui/button";
	import type { Patient } from "@/types/patient";
	import type { PaginatedResult } from "@/types/pagination";
	import PatientTableActions from "./patient-table-actions.svelte";
	import {
		ChevronLeft,
		ChevronRight,
		ChevronsLeft,
		ChevronsRight,
	} from "lucide-svelte";
	import { useForm } from "@inertiajs/svelte";
	import SearchInput from "../ui/input/search-input.svelte";
	import PaginationBar from "../table/pagination-bar.svelte";

	let {
		patients,
		search,
		pageSize,
	}: {
		patients: PaginatedResult<Patient>;
		search: string;
		pageSize: string;
	} = $props();

	const columns: ColumnDef<Patient>[] = [
		{
			accessorKey: "tenant_patient_number",
			header: "Patient Number",
		},
		{
			accessorKey: "name",
			header: "Patient Name",
		},
		{
			accessorKey: "date_of_birth",
			header: "Date of Birth",
		},
		{
			id: "actions",
			cell: ({ row }) => {
				return renderComponent(PatientTableActions, {
					id: row.original.id.toString(),
				});
			},
		},
	];

	const table = createSvelteTable({
		get data() {
			return patients.data;
		},
		columns,
		getCoreRowModel: getCoreRowModel(),
	});

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
			{#each table.getHeaderGroups() as headerGroup (headerGroup.id)}
				<Table.Row>
					{#each headerGroup.headers as header (header.id)}
						<Table.Head>
							{#if !header.isPlaceholder}
								<FlexRender
									content={header.column.columnDef.header}
									context={header.getContext()}
								/>
							{/if}
						</Table.Head>
					{/each}
				</Table.Row>
			{/each}
		</Table.Header>
		<Table.Body>
			{#each table.getRowModel().rows as row (row.id)}
				<Table.Row data-state={row.getIsSelected() && "selected"}>
					{#each row.getVisibleCells() as cell (cell.id)}
						<Table.Cell>
							<FlexRender
								content={cell.column.columnDef.cell}
								context={cell.getContext()}
							/>
						</Table.Cell>
					{/each}
				</Table.Row>
			{:else}
				<Table.Row>
					<Table.Cell
						colspan={columns.length}
						class="h-24 text-center"
					>
						No results.
					</Table.Cell>
				</Table.Row>
			{/each}
		</Table.Body>
	</Table.Root>
</div>

<div class="mt-4">
	<PaginationBar
		pagination={patients}
		pageSize={$form.pageSize}
		onPageSizeChange={(value) => {
			$form.pageSize = value;
			onSubmit();
		}}
	/>
</div>
