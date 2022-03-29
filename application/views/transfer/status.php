<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Check Status Transfer</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Transfer</li>
						<li class="breadcrumb-item active">Status</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
<style>
	.vertical-center {
		margin: 0;
		position: absolute;
		top: 60%;
		-ms-transform: translateY(-50%);
		transform: translateY(-50%);
	}
</style>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="callout callout-info">
					<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-warning" role="alert">
								Get fund transfer status from your bank account. Maximal account statement 31 days ago
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Transfer Request ID</label>
								<input type="text" class="form-control" id="transfer_request_id" name="transfer_request_id" placeholder="Transfer Request ID">
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<button class="btn btn-primary btn-block vertical-center" id="btn_check_status" onclick="checkStatus(this)">Get Data Transaction</button>
							</div>
						</div>
					</div>
					<?php
					if ($statusCheck == true && $dataExists == false) { ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="alert alert-danger" role="alert">
									Data tidak ditemukan
								</div>
							</div>
						</div>
					<?php } ?>

					<?php
					if ($statusCheck == true && $dataExists == true) {
						$data = json_decode($dataTransfer->data);
						?>
						<div class="row">
							<div class="col-lg-12">
								<div class="alert alert-success" role="alert">
									Data Transfer Ditemukan
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="col-lg-12">
									<div class="form-group">
										<label>Transfer Request ID</label>
										<input type="text" class="form-control" value="<?= $data->TransactionID ?>" disabled>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label>Transaction Date</label>
										<input type="text" class="form-control" value="<?= $data->TransactionDate ?>" disabled>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label>Reference ID </label>
										<input type="text" class="form-control" value="<?= $data->ReferenceID ?>" disabled>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label>Transfer Type </label>
										<input type="text" class="form-control" value="<?= $data->TransferType ?>" disabled>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label>Remark </label>
										<input type="text" class="form-control" value="<?= $data->Remark1 ?>" disabled>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="col-lg-12">
									<div class="form-group">
										<label>Source Account Number</label>
										<input type="text" class="form-control" value="<?= $data->SourceAccountNumber ?>" disabled>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label>Beneficiary Account Number</label>
										<input type="text" class="form-control" value="<?= $data->BeneficiaryAccountNumber ?>" disabled>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label>Beneficiary Bank Code </label>
										<input type="text" class="form-control" value="<?= $data->BeneficiaryBankCode ?>" disabled>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label>Beneficiary Name </label>
										<input type="text" class="form-control" value="<?= strtoupper($data->BeneficiaryName) ?>" disabled>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label>Amount </label>
										<input type="text" class="form-control" value="<?= $data->Amount . sprintf(' (%s)', $data->CurrencyCode) ?>" disabled>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php
				if ($statusCheck == true && $dataExists == true) {
					?>
					<div class="card">
						<div class="card-header">
							Status Transfer
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Transaction ID</th>
											<th>Transaction Date</th>
											<th>Transaction Date</th>
											<th>Beneficiary Account Number</th>
											<th>Amount</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
									<tr>
										<td><?= $data->TransactionID ?></td>
										<td><?= $data->TransactionDate ?></td>
										<td><?= $data->TransferType ?></td>
										<td><?= $data->BeneficiaryAccountNumber ?></td>
										<td><?= $data->Amount ?></td>
										<td><?= isset($resultBca["reason"]) ? $resultBca["reason"]["indonesian"] : $resultBca["errorMessage"]["indonesian"] ?></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				<?php } ?>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
	let btnCheckStatus = document.getElementById('btn_check_status')
	let inputTransferRequestId = document.getElementById('transfer_request_id')
	function checkStatus(e) {
		e.disabled = true
		e.innerHTML = "Loading data..."
		let transferRequestId = inputTransferRequestId.value
		if (transferRequestId === '') {
			e.disabled = false
			e.innerHTML = "Get Data Transaction"
			alert('Transfer Request ID is required')
			return
		}
		let url = `<?= base_url('transfer/status/') ?>${transferRequestId}`
		window.location.href = url
	}
</script>
