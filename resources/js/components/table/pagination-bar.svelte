<script lang="ts">
	import { Button } from "@/components/ui/button";
	import * as Select from "@/components/ui/select";
	import {
		ChevronLeft,
		ChevronRight,
		ChevronsLeft,
		ChevronsRight,
	} from "lucide-svelte";
	import type { PaginatedResult } from "@/types/pagination";

	let {
		pagination,
		pageSize = pagination.links.length.toString(),
		onPageSizeChange = () => {},
	}: {
		pagination: PaginatedResult<unknown>;
		pageSize: string;
		onPageSizeChange: (value: string) => void;
	} = $props();
</script>

<div class="flex items-center justify-between">
	<div class="text-muted-foreground flex-1 text-sm">
		{pagination.total} results
	</div>
	<div class="flex items-center space-x-6 lg:space-x-8">
		<div class="flex items-center space-x-2">
			<p class="text-sm font-medium">Rows per page</p>
			<Select.Root
				type="single"
				name="pageSize"
				value={pageSize}
				onValueChange={onPageSizeChange}
			>
				<Select.Trigger class="h-8 w-[70px]">{pageSize}</Select.Trigger>
				<Select.Content>
					<Select.Item value="10">10</Select.Item>
					<Select.Item value="20">20</Select.Item>
					<Select.Item value="30">30</Select.Item>
					<Select.Item value="40">40</Select.Item>
					<Select.Item value="50">50</Select.Item>
				</Select.Content>
			</Select.Root>
		</div>
		<div
			class="flex w-[100px] items-center justify-center text-sm font-medium"
		>
			Page {pagination.current_page} of {pagination.last_page}
		</div>
		<div class="flex items-center space-x-2">
			<Button
				variant="outline"
				class="hidden h-8 w-8 lg:flex"
				disabled={!pagination.first_page_url}
				href={pagination.first_page_url ?? ""}
			>
				<span class="sr-only">Go to first page</span>
				<ChevronsLeft size={16} />
			</Button>
			<Button
				variant="outline"
				class="h-8 w-8"
				disabled={!pagination.prev_page_url}
				href={pagination.prev_page_url ?? ""}
			>
				<span class="sr-only">Go to previous page</span>
				<ChevronLeft size={16} />
			</Button>
			<Button
				variant="outline"
				class="h-8 w-8"
				disabled={!pagination.next_page_url}
				href={pagination.next_page_url ?? ""}
			>
				<span class="sr-only">Go to next page</span>
				<ChevronRight size={16} />
			</Button>
			<Button
				variant="outline"
				class="hidden h-8 w-8 lg:flex"
				disabled={!pagination.last_page_url}
				href={pagination.last_page_url ?? ""}
			>
				<span class="sr-only">Go to last page</span>
				<ChevronsRight size={16} />
			</Button>
		</div>
	</div>
</div>
