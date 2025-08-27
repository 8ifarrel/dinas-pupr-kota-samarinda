<php>
return new class extends Migration {
    public function up(): void
    {
        Schema::table('sedot_tinja', function (Blueprint $table) {
            $table->string('alamat_detail')->nullable()->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('sedot_tinja', function (Blueprint $table) {
            $table->dropColumn('alamat_detail');
        });
    }
};
</php>